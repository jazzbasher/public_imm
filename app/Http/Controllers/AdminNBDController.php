<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewCustomerLeads;
use App\Models\NewOpportunities;
use App\Models\JointCalls;
use App\Models\Conversions;
use App\Models\CurrentPromo;
use App\Models\VendingPipeline;
use App\Models\User;

class AdminNBDController extends Controller
{

    public function nbddashboard()
    {
        $leadscount = NewCustomerLeads::where('active', 1)->count();
        $oppcount = NewOpportunities::where('active', 1)->count();
        $pipelinecount = VendingPipeline::where('active', 1)->count();
        $opportunitysum = NewOpportunities::where('active',1)->sum('projected_value');
        $pipelinesum = VendingPipeline::where('active',1)->sum('estimated_spend');

        $sumtotal = $opportunitysum + $pipelinesum;

        // $userleads = User::where('is_sales', 1)->withCount([
        //     'newcustomerleads' => function ($query) {
        //         $query->where('active', 1); 
        //     }])->withCount([
        //     'newopportunties' => function ($query) {
        //         $query->where('active', 1); 
        //     }])->get();

        $userleads = User::where('is_sales', 1)->withCount([
            'newcustomerleads' => function ($query) {
                $query->where('active', 1); 
            }])->withCount([
            'newopps' => function ($query) {
                $query->where('active', 1); 
            }])->withCount([
            'jointcalls' => function ($query) {
                $query->where('active', 1); 
            }])->withCount([
            'conversions' => function ($query) {
                $query->where('active', 1); 
            }])->withCount([
            'pipelines' => function ($query) {
                $query->where('active', 1); 
            }])->get();


         return view('nbd.admin.dashboard', compact('leadscount', 'oppcount', 'pipelinecount', 'sumtotal', 'userleads'));
    }
    
}
