<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Import SyncSystem Namespace (objects and helpers).
// use SyncSystemNS\ObjectCategoriesListing; // working
//use SyncSystemNS\*;

class CategoriesListing extends Model
{
    use HasFactory;

    //private float|string|null $_idParent = null;
    private array|null $ocdRecordParameters = null;
    private array|null $oclRecordsParameters = null;

    protected $objCategoriesListing;
    protected $arrCategoriesListing;

    // Constructor.
    // **************************************************************************************
    //public function __construct(?float $idParent = null)
    public function __construct(?array $_ocdRecordParameters = null, ?array $_oclRecordsParameters = null)
    {
        /*
        if ($idParent !== null) {
            $this->_idParent = $idParent;
        }
        */
        if ($_ocdRecordParameters !== null) {
            $this->ocdRecordParameters = $_ocdRecordParameters;
        }
        if ($_oclRecordsParameters !== null) {
            $this->oclRecordsParameters = $_oclRecordsParameters;
        }
    }
    // **************************************************************************************


    public function cphBodyBuild(): array
    {

        // ref: https://youtu.be/_CjKZ9FwEpQ?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD&t=239
        // create eloquent fetch

        // ref: https://youtu.be/KKOMJQBkPLE?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD&t=851
        // select data

        // ref: https://youtu.be/3Uy0KRPHQik?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD
        // CRUD API


        // Variables.
        // ----------------------
        $arrReturn = ['returnStatus' => false];
        // ----------------------

        // Logic.
        try {
            // Parameters build - details.
            /*
            $this->ocdRecordParameters = [
                '_arrSearchParameters' => ['id;' . $idTbCategories . ';i'],
                '_idTbCategories' => $idTbCategories,
                '_terminal' => $terminal,
                '_arrSpecialParameters' => [
                    'returnType' => 1, 
                    'pageNumber' => $this->pageNumber, 
                    'pagingNRecords' => $this->pagingNRecords
                ],
            ];
            */    
            
            // Build object - details.
            if ($this->ocdRecordParameters !== null) {
                $ocdRecord = new \SyncSystemNS\ObjectCategoriesDetails($this->ocdRecordParameters);
                $arrReturn['ocdRecord'] = $ocdRecord->recordDetailsGet(0, 1);
            }


            // Parameters build - listing.
            /*
            (array) $oclRecordsParameters = [
                '_arrSearchParameters' => [],
                '_configSortOrder' => $GLOBALS['configCategoriesSort'],
                '_strNRecords' => '',
                '_arrSpecialParameters' => ['returnType' => 1],
            ];
            */            

            // Build object - listing.
            if ($this->oclRecordsParameters !== null) {
                //$oclRecords = new \SyncSystemNS\ObjectCategoriesListing($oclRecordsParameters);
                $oclRecords = new \SyncSystemNS\ObjectCategoriesListing($this->oclRecordsParameters);
                $arrReturn['oclRecords'] = $oclRecords->recordsListingGet(0, 1);
                //$oclRecords = new ObjectCategoriesListing();

                if ($arrReturn['oclRecords']['returnStatus'] === true) {
                    $arrReturn['returnStatus'] = true;
                }
            }


            // Debug.
            //echo 'this->_idParent=' . $this->_idParent . '<br />';
            //echo 'this->oclRecordsParameters=<pre>';
            //var_dump($this->oclRecordsParameters);
            //echo '</pre><br />';

            //echo 'oclRecords=<pre>';
            //var_dump($oclRecords);
            //echo '</pre><br />';

            //return 'content inside model: ' . $this->_idParent; // debug.
            return $arrReturn;
        } catch (Error $cphBodyBuildError) {
            if ($GLOBALS['configDebug'] === true) {
                throw new Error('cphBodyBuildError: ' . $cphBodyBuildError->message());
            }
        } finally {

        }
    }
}
