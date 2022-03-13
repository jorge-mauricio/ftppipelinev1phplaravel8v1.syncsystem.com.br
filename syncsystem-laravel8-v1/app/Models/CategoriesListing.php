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

    private float|string|null $_idParent = null;

    protected $objCategoriesListing;
    protected $arrCategoriesListing;

    // Constructor.
    // **************************************************************************************
    public function __construct(?float $idParent = null)
    {
        if ($idParent !== null) {
            $this->_idParent = $idParent;
        }
    }
    // **************************************************************************************


    public function cphBodyBuild(): string
    {

        // ref: https://youtu.be/_CjKZ9FwEpQ?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD&t=239
        // create eloquent fetch

        // ref: https://youtu.be/KKOMJQBkPLE?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD&t=851
        // select data

        // ref: https://youtu.be/3Uy0KRPHQik?list=PLz_YkiqIHesvWMGfavV8JFDQRJycfHUvD
        // CRUD API


        // Variables.
        // ----------------------
        (array) $arrReturn = ['returnStatus' => false];

        // ----------------------


        // Parameters build - listing.
        (array)$oclRecordsParameters = [
            '_arrSearchParameters' => [],
            '_configSortOrder' => $GLOBALS['configCategoriesSort'],
            '_strNRecords' => '',
            '_arrSpecialParameters' => ['returnType' => 1],
        ];


        // ObjectCategoriesListing
        $oclRecords = new \SyncSystemNS\ObjectCategoriesListing($oclRecordsParameters);
        $arrReturn['oclRecords'] = $oclRecords->recordsListingGet(0, 3);
        //$oclRecords = new ObjectCategoriesListing();
        

        return 'content inside model: ' . $this->_idParent;

    }
}
