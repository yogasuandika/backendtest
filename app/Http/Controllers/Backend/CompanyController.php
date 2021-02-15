<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Postcode;
use App\Models\Prefecture;
use DB;
use Config;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        return view('backend.company.list');
    }

    public function autocomplete(Request $request)
    {
        $term=$request->postcode;
        //$getFields = Postcode::where('postcode',$term)->first();
        $getFields = DB::table('prefectures')->join('postcodes','postcodes.prefecture', 'prefectures.display_name')
        ->select('postcodes.prefecture','postcodes.city','postcodes.local', 'prefectures.*')->where('postcode',$term)->first();

        $data = array(
            'id' => $getFields->id,
            'city' => $getFields->city,
            'local' => $getFields->local,
        );
        //echo print_r($data);
        return json_encode($data); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add()
    {
        $getFields = Postcode::all();
        $prefecture = Prefecture::all();
        $company = new Company();
        $company->page_title = 'Company Add Page';
        $company->page_type = 'create';
        return view('backend.company.add', [
            'company' => $company
        ], compact('prefecture','getFields'));
    }

    public function create()
    {
        
        //
    
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required | email',
            'city' => 'required',
            'local' => 'required',
            'image' => 'required',
        ]);

        $input= $request->all();
        $company = new Company;

        $company->id = $input['id'];
        $company->name = $input['name'];
        $company->email =$input['email'];
        $company->prefecture_id =$input['prefecture'];
        $company->postcode =$input['postcode'];
        $company->city =$input['city'];
        $company->local =$input['local'];
        $company->street_address =$input['streetaddress'];
        $company->phone =$input['phone'];
        $company->business_hour =$input['businesshour'];
        $company->regular_holiday = $input['regularholiday'];
        $company->fax = $input['fax'];
        $company->url = $input['url'];
        $company->license_number = $input['licensenumber'];
        $company->save();

        $image = $request->file('image');
        $new_name= 'Image'.'_'.$company->id.'.'.$image->getClientOriginalExtension();
        //nama folder tempat kemana file diupload
        $tujuan_upload = 'uploads/files';
        $image->move($tujuan_upload,$new_name);

        $company->image = $new_name;

        $company->save();
        return redirect()->back()->with('message', 'Data Successfull Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        $prefecture = \App\Models\Prefecture::all();
        $company->page_title = 'Company Edit Page';
        $company->page_type = 'Edit';
        return view('backend.company.edit', compact('prefecture','company'));
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required | email',
            'city' => 'required',
            'local' => 'required',
            'image' => 'required',
        ]);
        
        $update = Company::findOrFail($request->id);
        $id=$request->id;
        $update->name = $request->name;
        $update->email = $request->email;
        $update->prefecture_id = $request->prefecture;
        $update->phone = $request->phone;
        $update->postcode = $request->postcode;
        $update->city = $request->city;
        $update->local = $request->local;
        $update->street_address = $request->streetaddress;
        $update->business_hour = $request->businesshour;
        $update->regular_holiday = $request->regularholiday;
        $update->fax = $request->fax;
        $update->url = $request->url;
        $update->license_number = $request->license_number;

        $image = $request->file('image');
        $new_name= 'Image'.'_'.$id.'.'.$image->getClientOriginalExtension();
        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'uploads/files';
        $image->move($tujuan_upload,$new_name);

        $update->image = $new_name;
        
        $update->update();

        return view('backend.company.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request){
        // Get comapnies by id
        $company = Company::find($request->get('id'));
        $company->delete();
        return redirect()->back()->with('success', Config::get('const.SUCCESS_DELETE_MESSAGE'));
            
    }
}