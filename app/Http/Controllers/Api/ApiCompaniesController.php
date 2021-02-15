<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use DB;

class ApiCompaniesController extends Controller {

    /**
     * Return the contents of User table in tabular form
     *
     */
    public function getCompaniesTabular() {
        //$company = Company::orderBy('id', 'desc')->get();
        $company= DB::table('prefectures')->join('companies', 'companies.prefecture_id', 'prefectures.id')
            ->select('companies.*', 'prefectures.display_name')->orderBy('companies.id','desc')->get();
        return response()->json($company);
    }

}
