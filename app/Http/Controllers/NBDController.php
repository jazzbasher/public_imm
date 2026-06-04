<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewCustomerLeads;
use App\Models\NewOpportunities;
use App\Models\JointCalls;
use App\Models\Conversions;
use App\Models\CurrentPromo;
use App\Models\VendingPipeline;
use Illuminate\Support\Facades\Auth;


class NBDController extends Controller
{
    

    /**********************************************************************************************
     * ********************************************************************************************
     * ***********************     NBD View Logic       *******************************************
     * ********************************************************************************************
     * *******************************************************************************************/




    public function newleads()
    {

        $loggeduser = Auth::id();

        $newlead = NewCustomerLeads::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();
        $countleads = NewCustomerLeads::where('user_id', $loggeduser)->where('contact_made', 1)->count();
        $countalerts = NewCustomerLeads::where('user_id', $loggeduser)->whereDate('date_planned', '>=', today())->count();
        
        return view('nbd.newleads', compact('newlead', 'countleads', 'countalerts'));
    }


    public function newopportunities()
    {

        $loggeduser = Auth::id();

        $newopportunity = NewOpportunities::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();
        $countquotes = NewOpportunities::where('user_id', $loggeduser)->where('quote', 1)->count();
        $countclose = NewOpportunities::where('user_id', $loggeduser)->whereDate('close_date', '>=', today())->count();
        
        return view('nbd.newopportunities', compact('newopportunity', 'countquotes', 'countclose'));
    }


    public function jointcalls()
    {

        $loggeduser = Auth::id();

        $jointcalls = JointCalls::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();
        $countworked = JointCalls::where('user_id', $loggeduser)->whereDate('date_worked', '>=', today())->count();
        
        return view('nbd.jointcalls', compact('jointcalls', 'countworked'));
    }


    public function conversions()
    {

        $loggeduser = Auth::id();

        $conversions = Conversions::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();

        
        return view('nbd.conversions', compact('conversions'));
    }



    public function currentpromo()
    {

        $loggeduser = Auth::id();

        $promos = CurrentPromo::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();

        
        return view('nbd.currentpromo', compact('promos'));
    }


    public function vendingpipeline()
    {

        $loggeduser = Auth::id();

        $pipelines = VendingPipeline::where('user_id', $loggeduser)->orderBy('created_at', 'desc')->get();

        
        return view('nbd.vendingpipeline', compact('pipelines'));
    }











    /**********************************************************************************************
     * ********************************************************************************************
     * ***********************  Launch NBD Create Forms *******************************************
     * ********************************************************************************************
     * *******************************************************************************************/



    public function createnewlead()
    {
        return view('nbd.create.createlead');
    }



     public function createnewopportunity()
    {
        return view('nbd.create.createopportunity');
    }

     public function createnewjointcall()
    {
        return view('nbd.create.createjointcall');
    }


    public function createnewconversion()
    {
        return view('nbd.create.createconversion');
    }


    public function createnewpromo()
    {
        return view('nbd.create.createpromo');
    }


    public function createnewpipeline()
    {
        return view('nbd.create.createpipeline');
    }









     /**********************************************************************************************
     * ********************************************************************************************
     * ***********************   NBD Store To DB Logic   *******************************************
     * ********************************************************************************************
     * *******************************************************************************************/



    public function storelead(Request $request)
    {
        if($request->boolean('contact_made') == true) {
            $contactmade = 1;
        }
        else {
            $contactmade = 0;
        }

        $request->merge([
            'contact_made' => $contactmade
        ]);

         $request->validate([
            'new_lead' => 'max:255',
            'address' => 'max:255|nullable',
            'user_id' => 'required',
            'date_planned' => 'date_format:Y-m-d|nullable',
            'contact_made' => 'nullable',
            'contactname' => 'max:255|nullable',
            'email' => 'max:255|nullable',
            'comments' => 'max:500|nullable'

        ]);

        NewCustomerLeads::create($request->all());

        return redirect()->route('nbd.newleads')->with('success', 'Entry created successfully!');
    }





    public function storeopportunity(Request $request)
    {
        if($request->boolean('quote') == true) {
            $quote = 1;
        }
        else {
            $quote = 0;
        }

        $request->merge([
            'quote' => $quote
        ]);

         $request->validate([
            'customer' => 'max:255',
            'interest' => 'max:255|nullable',
            'user_id' => 'required',
            'close_date' => 'date_format:Y-m-d|nullable',
            'projected_value' => 'nullable',
            'confidence' => 'nullable',
            'rep' => 'max:255|nullable',
            'comments' => 'max:500|nullable'

        ]);

        NewOpportunities::create($request->all());

        return redirect()->route('nbd.newopportunities')->with('success', 'Entry created successfully!');
    }


    public function storejointcall(Request $request)
    {
        $request->validate([
            'customer_name' => 'max:255|nullable',
            'vendor' => 'max:255|nullable',
            'vendor_rep' => 'max:255|nullable',
            'user_id' => 'required',
            'date_worked' => 'date_format:Y-m-d|nullable',
            'comments' => 'max:500|nullable'
        ]);

        JointCalls::create($request->all());

        return redirect()->route('nbd.jointcalls')->with('success', 'Entry created successfully!');
    }




    public function storeconversion(Request $request)
    {
        $request->validate([
            'new_supplier' => 'max:255|nullable',
            'supplier_converted_from' => 'max:255|nullable',
            'annual_opp_volume' => 'nullable',
            'supplier_contact_name' => 'max:255|nullable',
            'end_user' => 'max:255|nullable',
            'product_converted_to' => 'max:255|nullable',
            'user_id' => 'required',
            'comments' => 'max:500|nullable'
        ]);

        Conversions::create($request->all());

        return redirect()->route('nbd.conversions')->with('success', 'Entry created successfully!');
    }


    public function storepromo(Request $request)
    {
        $request->validate([
            'promo_date' => 'date_format:Y-m-d|nullable',
            'customer' => 'max:255|nullable',
            'contact_name' => 'nullable',
            'sample' => 'max:255|nullable',
            'user_id' => 'required',
            'comments' => 'max:500|nullable'
        ]);

        CurrentPromo::create($request->all());

        return redirect()->route('nbd.currentpromo')->with('success', 'Entry created successfully!');
    }


    public function storepipeline(Request $request)
    {

        if($request->boolean('presentation') == true) {
            $presentation = 1;
        }
        else {
            $presentation = 0;
        }

        if($request->boolean('site_survey') == true) {
            $sitesurvey = 1;
        }
        else {
            $sitesurvey = 0;
        }

        $request->merge([
            'presentation' => $presentation,
            'site_survey' => $sitesurvey
        ]);


        $request->validate([
            'customer' => 'max:255|nullable',
            'address' => 'max:255|nullable',
            'estimated_spend' => 'nullable',
            'user_id' => 'required',
            'comments' => 'max:500|nullable'
        ]);

        VendingPipeline::create($request->all());

        return redirect()->route('nbd.vendingpipeline')->with('success', 'Entry created successfully!');
    }










    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
