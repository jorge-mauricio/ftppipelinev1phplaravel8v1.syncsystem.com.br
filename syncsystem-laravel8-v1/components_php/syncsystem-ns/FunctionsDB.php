<?php
namespace SyncSystemNS;

use Illuminate\Support\Facades\DB;
// use PDO;

class FunctionsDB
{
    // Function to return results from any field in table.
    // **************************************************************************************
    /**
     * Function to return results from any field in table.
     * @static
     * @param float idRecord
     * @param string strTable categories | content | files | publications | products | registers | quizzes | forms | forms_fields | forms_fields_options
     * @param string fieldName
     * @return string
     * @example \SyncSystemNS\FunctionsDB::genericFieldGet01(790, $GLOBALS['configSystemDBTableFiltersGeneric'], 'title')
     */
    static function genericFieldGet01(float $idRecord, string $strTable, string $fieldName): string
    {
        // Variables.
        // ----------------------
        $strReturn = '';
        $objResultGenericField;
        $strSQLGenericFieldSelect = '';
        $strSQLGenericFieldSelectParams = [];
        // ----------------------

        if ($strTable && $idRecord) {
            // Logic.
                // ----------------------
            try {
                $objResultGenericField = DB::table(env('CONFIG_SYSTEM_DB_TABLE_PREFIX') . $strTable);
                $objResultGenericField = $objResultGenericField->select($fieldName);
                $objResultGenericField = $objResultGenericField->where('id', '=', (float)\SyncSystemNS\FunctionsGeneric::contentMaskWrite($idRecord, 'db_sanitize'));
                $objResultGenericField = $objResultGenericField->get()->toArray();

                // Return data treatment.
                if (count($objResultGenericField) > 0 ) {
                    // $strReturn = $objResultGenericField[0][$fieldName];
                    $strReturn = $objResultGenericField[$fieldName];
                    // $strReturn = $objResultGenericField;
                }

                // Debug.
                // dd($strReturn);
                // ----------------------
            } catch (Error $genericFieldGet01Error) {
                if ($GLOBALS['configDebug'] === true) {
                    throw new Error('genericFieldGet01: ' . $genericFieldGet01Error->message());
                }
            } finally {

            }
            // ----------------------
        } else {
            $strReturn = '';
        }

        return $strReturn;

        // Usage.
        // ----------------------
        // \SyncSystemNS\FunctionsDB::genericFieldGet01(790, $GLOBALS['configSystemDBTableFiltersGeneric'], 'title')
        // ----------------------
    }
    // **************************************************************************************


    // Function to return results from any table.
    // **************************************************************************************
    /**
     * Function to return results from any table.
     * @static
     * @param string strTable categories | content | files | publications | products | registers | quizzes | forms | forms_fields | forms_fields_options
     * @param array arrSearchParameters ["fieldNameSearch1;fieldValueSearch1;fieldTypeSearch1", "fieldNameSearch2;fieldValueSearch2;fieldTypeSearch2", "fieldNameSearch3;fieldValueSearch3;fieldTypeSearch3"]
     * @param string configSortOrder
     * @param string strNRecords
     * @param string strReturnFields field names, separated by commas. Ex: id, id_parent
     * @param float searchType 1 - all results | 2 - first result | 3 - count records
     * @param object arrSpecialParameters ['returnType' => 3, 'pageNumber' => 2, 'pagingNRecords' => 20]
     * @return array
     */
    static function genericTableGet02(string $strTable,
        array|null $arrSearchParameters,
        string $configSortOrder = '',
        string $strNRecords = '',
        string $strReturnFields = '',
        float $searchType = 1,
        array $arrSpecialParameters = [ 'returnType' => 1 ]
    ): array|null
    {
        // Variables.
        // ----------------------
        //$arrReturn = null;
        $arrReturn['returnStatus'] = false;

        //(string) $strSQLGenericTableSelect = '';
        //(array) $strSQLGenericTableSelectParams = [];

        $resultsSQLGenericTable = null;

        $pageNumber = array_key_exists('pageNumber', $arrSpecialParameters) && $arrSpecialParameters['pageNumber'] !== null ? $arrSpecialParameters['pageNumber'] : '';
        $pagingNRecords = array_key_exists('pagingNRecords', $arrSpecialParameters) && $arrSpecialParameters['pagingNRecords'] !== null ? $arrSpecialParameters['pagingNRecords'] : '';

        $strOperator = '';
        // ----------------------

        // Logic.
        try {
            //DB::setFetchMode(PDO::FETCH_ASSOC);
            // $resultsSQLGenericTable = DB::table('posts')->where('id', $id);
            //->toArray()
            $resultsSQLGenericTable = DB::table(env('CONFIG_SYSTEM_DB_TABLE_PREFIX') . $strTable);

            if ($strReturnFields !== '') {
                $resultsSQLGenericTable = $resultsSQLGenericTable->select(explode(',', $strReturnFields));
            }

            // Parameters.
            /**/
            if (count($arrSearchParameters) > 0) {
                // Loop through parameters.
                for ($countArray = 0; $countArray < count($arrSearchParameters); $countArray++) {
                    $arrSearchParametersInfo = explode(';', $arrSearchParameters[$countArray]);
                    $searchParametersFieldName = $arrSearchParametersInfo[0];
                    $searchParametersFieldValue = $arrSearchParametersInfo[1];
                    $searchParametersFieldType = $arrSearchParametersInfo[2];
    
                    // Integer.
                    if ($searchParametersFieldType === 'i') {
                        $resultsSQLGenericTable = $resultsSQLGenericTable->where($searchParametersFieldName, '=', (float)\SyncSystemNS\FunctionsGeneric::contentMaskWrite($searchParametersFieldValue, 'db_sanitize'));
    
                        //$strSQLGenericTableSelect += ' ' + $strOperator + ' ' + FunctionsGeneric.contentMaskWrite(searchParametersFieldName, 'db_sanitize') + ' = ?';
                        //$strSQLGenericTableSelectParams.push(searchParametersFieldValue);
                    }
                    // ->whereRaw

                    // Debug.
                    /*
                    echo 'arrSearchParameters=' . $arrSearchParameters[$countArray] . '<br />';
                    echo 'searchParametersFieldName=' . $searchParametersFieldName . '<br />';
                    echo 'searchParametersFieldValue=' . $searchParametersFieldValue . '<br />';
                    echo 'searchParametersFieldType=' . $searchParametersFieldType . '<br />';
                    */
                }
            } else {
                $resultsSQLGenericTable = $resultsSQLGenericTable->where('id', '=', 0);
            }
            //$resultsSQLGenericTable = $resultsSQLGenericTable->where('id_parent', '=', 781); //debug

            // Sort order.
            if ($configSortOrder !== '') {
                $resultsSQLGenericTable = $resultsSQLGenericTable->orderBy($configSortOrder); // sortBy
            }

            // Limit.
            if ($strNRecords !== '') {
                $resultsSQLGenericTable = $resultsSQLGenericTable->limit($strNRecords);
            }

            // Paging.
            // if ($pageNumber !== '' && $pageNumber !== null && $pagingNRecords !== '' && $pagingNRecords !== null) {
            if ($pageNumber !== '' && $pagingNRecords !== '') {
                // Logic - calculating limit.
                $limitStart = ($pageNumber * $pagingNRecords) - $pagingNRecords;
                // let limitEnd = pageNumber * pagingNRecords; // wrong
                $limitEnd = $pagingNRecords;

                $resultsSQLGenericTable = $resultsSQLGenericTable->offset($limitStart)->take($pagingNRecords);
            }
            
            $resultsSQLGenericTable = $resultsSQLGenericTable->get();
            /*
            if ($strReturnFields !== '') {
                $resultsSQLGenericTable = $resultsSQLGenericTable->get(explode(',', $strReturnFields));
            } else {
                $resultsSQLGenericTable = $resultsSQLGenericTable->get();
            }
            */

            if ($arrSpecialParameters['returnType'] === 1) {
                $resultsSQLGenericTable = $resultsSQLGenericTable->toArray();
            }


            if ($resultsSQLGenericTable !== null) {
                //$arrReturn = $resultsSQLGenericTable;
                // $arrReturn = ['returnStatus' => true, ...$resultsSQLGenericTable]; // worked
                $arrReturn = array_merge(['returnStatus' => true], $resultsSQLGenericTable);
                //$arrReturn = $resultsSQLGenericTable["items"];
            }

            // Debug.
            /*
            echo 'CONFIG_SYSTEM_DB_TABLE_PREFIX=' . env('CONFIG_SYSTEM_DB_TABLE_PREFIX') . '<br />';

            //echo 'arrReturn=' . $arrReturn . '<br />';
            echo 'strSQLGenericTableSelect=' . $strSQLGenericTableSelect . '<br />';

            echo 'strSQLGenericTableSelectParams=<pre>';
            var_dump($strSQLGenericTableSelectParams);
            echo '</pre><br />';

            //echo 'resultsSQLGenericTable=<pre>';
            //var_dump($resultsSQLGenericTable);
            //echo '</pre><br />';
            */

            //echo 'arrSearchParameters (inside FunctionsDB)=<pre>';
            //var_dump($arrSearchParameters);
            //echo '</pre><br />';

            //echo 'configSortOrder=' . $configSortOrder . '<br />';

            //echo 'pageNumber=' . $pageNumber . '<br />';
            //echo 'pagingNRecords=' . $pagingNRecords . '<br />';
            //echo 'strOperator=' . $strOperator . '<br />';

            //echo 'contentMaskWrite=' . \SyncSystemNS\FunctionsGeneric::contentMaskWrite('testing contentMaskWrite', 'db_sanitize') . '<br />';

            return $arrReturn;
        } catch (Error $genericTableGet02Error) {
            if ($GLOBALS['configDebug'] === true) {
                throw new Error('genericTableGet02Error: ' . $genericTableGet02Error->message());
            }
        } finally {

        }

    }
    // **************************************************************************************
}