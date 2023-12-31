<?php

declare(strict_types=1);

namespace SyncSystemNS;

use Illuminate\Support\Facades\DB;

class FunctionsDBUpdate
{
    // Function to update a generic record field.
    // **************************************************************************************
    /**
     * Function to update a generic record field.
     * @static
     * @param string $strTable
     * @param string $strField
     * @param string $recordValue
     * @param array $arrSearchParameters
     * @return array|null
     * @example
     * $updateRecordsGeneric10Result = \SyncSystemNS\FunctionsDBUpdate::updateRecordGeneric10(strTable,
     * $strField,
     * $recordValue,
     * ['id;' . idRecord . ';i']);
     */
    public static function updateRecordGeneric10(
        string $strTable,
        string $strField,
        string $recordValue,
        ?array $arrSearchParameters
    ): array|null {
        // $arrSearchParameters: ['fieldNameSearch1;fieldValueSearch1;fieldTypeSearch1', 'fieldNameSearch2;fieldValueSearch2;fieldTypeSearch2', 'fieldNameSearch3;fieldValueSearch3;fieldTypeSearch3']
            // $typeFieldSearch1: s (string) | i (integer) | d (date) | dif (initial date and final date) | ids (id IN)

        // Variables.
        // ----------------------
        // let strReturn = false;
        $arrReturn = [ 'returnStatus' => false, 'nRecords' => 0 ];
        $objSQLRecordsGenericUpdate = '';
        $arrSQLRecordsGenericUpdateParams = [];
        $resultsSQLRecordsGenericUpdate = null;

        $strOperator = '';
        // ----------------------

        // Logic.
        try {
            $objSQLRecordsGenericUpdate = DB::table(config('app.gSystemConfig.configSystemDBTablePrefix') . $strTable);

            // Parameters.
            if (count($arrSearchParameters) > 0) {
                // Loop through parameters.
                for ($countArray = 0; $countArray < count($arrSearchParameters); $countArray++) {
                    $arrSearchParametersInfo = explode(';', $arrSearchParameters[$countArray]);
                    $searchParametersFieldName = $arrSearchParametersInfo[0];
                    $searchParametersFieldValue = $arrSearchParametersInfo[1];
                    $searchParametersFieldType = $arrSearchParametersInfo[2];

                    // Integer.
                    if ($searchParametersFieldType === 'i') {
                        $objSQLRecordsGenericUpdate = $objSQLRecordsGenericUpdate->where($searchParametersFieldName, '=', (float)\SyncSystemNS\FunctionsGeneric::contentMaskWrite($searchParametersFieldValue, 'db_sanitize'));
                    }
                }
            }

            $arrSQLRecordsGenericUpdateParams = [$strField => \SyncSystemNS\FunctionsGeneric::contentMaskWrite($recordValue, 'db_sanitize')];

            // Debug.
            // dd($apiCategoriesListingCurrentResponse);
            // echo 'objSQLRecordsGenericUpdate=<pre>';
            // var_dump($objSQLRecordsGenericUpdate);
            // echo '</pre>';
            // echo 'recordValue (inside function)=<pre>';
            // var_dump($recordValue);
            // echo '</pre>';
            // echo 'db_sanitize=<pre>';
            // var_dump(\SyncSystemNS\FunctionsGeneric::contentMaskWrite($recordValue, 'db_sanitize'));
            // echo '</pre>';
            // exit();

            $objSQLRecordsGenericUpdate = $objSQLRecordsGenericUpdate->update($arrSQLRecordsGenericUpdateParams);

            //echo 'updateRecordGeneric10=' . $objSQLRecordsGenericUpdate . '<br />';
        } catch (\Exception $updateRecordGeneric10Error) {
            if (config('app.gSystemConfig.configDebug') === true) {
                throw new \Error('updateRecordGeneric10Error: ' . $updateRecordGeneric10Error->getMessage());
            }
        } finally {
            //echo 'updateRecordGeneric10=' . $objSQLRecordsGenericUpdate . '<br />';
            //echo 'objSQLRecordsGenericUpdate=<pre>';
            //var_dump($objSQLRecordsGenericUpdate);
            //echo '</pre>';

            //exit();

            // Build return array.
            if ($objSQLRecordsGenericUpdate >= 0) {
                // Note: If values are the same, it will return 0 and not update DB.
                if ($objSQLRecordsGenericUpdate === 0) {
                    $arrReturn = ['returnStatus' => true, 'nRecords' => 1];
                } else {
                    $arrReturn = ['returnStatus' => true, 'nRecords' => $objSQLRecordsGenericUpdate];
                }
            }
        }

        return $arrReturn;

        // Usage.
        // ----------------------
        /*
            $updateRecordsGeneric10Result = \SyncSystemNS\FunctionsDBUpdate::deleteRecordsGeneric10(strTable,
                'strField',
                recordValue,
                ["id;" . idRecord . ";i"]);
            */
        // ----------------------
    }
    // **************************************************************************************

    // Function to update a generic record multiple fields.
    // **************************************************************************************
    /**
     * Function to update a generic record multiple fields.
     * @static
     * @param string $strTable
     * @param array $arrData ['fieldName' => 'recordValue']
     * @param array $arrSearchParameters
     * @return array|null
     * @example
     * $updateRecordMultipleGeneric = \SyncSystemNS\FunctionsDBUpdate::updateRecordMultipleGeneric(strTable,
     * ['fieldName' => 'recordValue'],
     * ['id;' . idRecord . ';i']);
     */
    public static function updateRecordMultipleGeneric(
        string $strTable,
        ?array $arrData,
        ?array $arrSearchParameters
    ): array|null {
        // $arrSearchParameters: ['fieldNameSearch1;fieldValueSearch1;fieldTypeSearch1', 'fieldNameSearch2;fieldValueSearch2;fieldTypeSearch2', 'fieldNameSearch3;fieldValueSearch3;fieldTypeSearch3']
            // $typeFieldSearch1: s (string) | i (integer) | d (date) | dif (initial date and final date) | ids (id IN)

        // Variables.
        // ----------------------
        // let strReturn = false;
        $arrReturn = ['returnStatus' => false, 'nRecords' => 0];
        $objSQLRecordsGenericUpdate = '';
        $arrSQLRecordsGenericUpdateParams = [];
        $resultsSQLRecordsGenericUpdate = null;

        $strOperator = '';
        // ----------------------

        // Logic.
        try {
            $objSQLRecordsGenericUpdate = DB::table(config('app.gSystemConfig.configSystemDBTablePrefix') . $strTable);

            // Parameters.
            if (count($arrSearchParameters) > 0) {
                // Loop through parameters.
                for ($countArray = 0; $countArray < count($arrSearchParameters); $countArray++) {
                    $arrSearchParametersInfo = explode(';', $arrSearchParameters[$countArray]);
                    $searchParametersFieldName = $arrSearchParametersInfo[0];
                    $searchParametersFieldValue = $arrSearchParametersInfo[1];
                    $searchParametersFieldType = $arrSearchParametersInfo[2];

                    // Integer.
                    if ($searchParametersFieldType === 'i') {
                        $objSQLRecordsGenericUpdate = $objSQLRecordsGenericUpdate->where($searchParametersFieldName, '=', (float)\SyncSystemNS\FunctionsGeneric::contentMaskWrite($searchParametersFieldValue, 'db_sanitize'));
                    }
                }
            }

            // TODO: sanitize arrData.
            $arrSQLRecordsGenericUpdateParams = $arrData;

            $objSQLRecordsGenericUpdate = $objSQLRecordsGenericUpdate->update($arrSQLRecordsGenericUpdateParams);

            // Build return array.
            if ($objSQLRecordsGenericUpdate >= 0) {
                // Note: If values are the same, it will return 0 and not update DB.
                if ($objSQLRecordsGenericUpdate === 0) {
                    $arrReturn = ['returnStatus' => true, 'nRecords' => 1];
                } else {
                    $arrReturn = ['returnStatus' => true, 'nRecords' => $objSQLRecordsGenericUpdate];
                }
            }
        } catch (\Exception $updateRecordMultipleGeneric) {
            if (config('app.gSystemConfig.configDebug') === true) {
                throw new \Error('updateRecordMultipleGeneric: ' . $updateRecordMultipleGeneric->getMessage());
            }
        } finally {
            //
        }

        return $arrReturn;

        // Usage.
        // ----------------------
        /*
            $updateRecordMultipleGeneric = \SyncSystemNS\FunctionsDBUpdate::deleteRecordsGeneric10(strTable,
                ['fieldName' => 'recordValue'],
                ["id;" . idRecord . ";i"]);
            */
        // ----------------------
    }
    // **************************************************************************************
}
