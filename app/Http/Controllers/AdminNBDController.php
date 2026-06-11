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
use Carbon\Carbon;

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

    public function yesNo($value){
    return $value ? 'Yes' : 'No';
}

    public function usersales($id)
    {
        $userquery = User::where('id', $id)->with([
            'newcustomerleads' => function ($query) {
                $query->where('active', 1); 
            }])->with([
            'newopps' => function ($query) {
                $query->where('active', 1); 
            }])->with([
            'jointcalls' => function ($query) {
                $query->where('active', 1); 
            }])->with([
            'conversions' => function ($query) {
                $query->where('active', 1); 
            }])->with([
            'pipelines' => function ($query) {
                $query->where('active', 1); 
            }])->get();

       $salesperson = null;

        $leadheads = ['Lead', 'Address', 'Planned', 'Contact?', 'Name', 'email', 'Notes', 'Created', '', ''];

        $oppsheads = ['Customer', 'Interest', 'Quote?', 'ProjectedValue', 'CloseDate', 'Confidence', 'Rep', 'Notes', 'Created', '', ''];

        $callsheads = ['Customer', 'Vendor', 'Rep', 'Worked', 'Notes','Created', '', ''];

        $conversionsheads = ['NewSupplier', 'ConvertedFrom', 'AOV', 'ContactName', 'EndUser', 'ConvertedTo', 'Notes','Created', '', ''];

        $pipelinesheads = ['Customer', 'Address', 'Estimated$', 'Presentation?', 'Notes', 'Created', '', ''];



        $dataleads = [];
        $dataopps = [];
        $datacalls = [];
        $dataconversions = [];
        $datapipelines = [];

        foreach ($userquery as $user) {

            $salesperson = $user->name;

            foreach($user->newcustomerleads as $lead) {

            $dataleads[] = [
                $lead->new_lead,
                $lead->address,
                Carbon::parse($lead->date_planned)->format('m-d-y'),
                $this->yesNo($lead->contact_made),
                $lead->contactname,
                $lead->email,
                $lead->comments,
                Carbon::parse($lead->created_at)->format('m-d-y'),
                '<a style="color: #9999B0;" href="/nbd/newleads/edit/' . $lead->id . '"><i class="fas fa-pencil-alt"/></a>',

                '<form action="/admin/destroylead" method="POST" onsubmit="return confirm(\'This action will delete this lead.  Are you sure?\');">' .
                '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                '<input type="hidden" name="id" value ="' . $lead->id . '">' .
                '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                '</form>',

                ];
            }

            foreach($user->newopps as $opps) {

                $dataopps[] = [
                    $opps->customer,
                    $opps->interest,
                    $this->yesNo($opps->quote),
                    $opps->projected_value !== null ? number_format($opps->projected_value,0) : '',
                    Carbon::parse($opps->close_date)->format('m-d-y'),
                    $opps->confidence,
                    $opps->rep,
                    $opps->comments,
                    Carbon::parse($opps->created_at)->format('m-d-y'),
                    '<a style="color: #9999B0;" href="/nbd/newopportunities/edit/' . $opps->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroyopportunity" method="POST" onsubmit="return confirm(\'This action will delete this opportunity.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $opps->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }

            foreach($user->jointcalls as $calls) {

                $datacalls[] = [
                    $calls->customer_name,
                    $calls->vendor,
                    $calls->vendor_rep,
                    Carbon::parse($calls->date_worked)->format('m-d-y'),
                    $calls->comments,
                    Carbon::parse($calls->created_at)->format('m-d-y'),
                    '<a style="color: #9999B0;" href="/nbd/jointcalls/edit/' . $calls->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroyjointcall" method="POST" onsubmit="return confirm(\'This action will delete this call.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $calls->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }

            foreach($user->conversions as $conversion) {

                $dataconversions[] = [
                    $conversion->new_supplier,
                    $conversion->supplier_converted_from,
                    $conversion->annual_opp_volume !== null ? number_format($conversion->annual_opp_volume,0) : '',
                    $conversion->supplier_contact_name,
                    $conversion->end_user,
                    $conversion->product_converted_to,
                    $conversion->comments,
                    Carbon::parse($conversion->created_at)->format('m-d-y'),
                    '<a style="color: #9999B0;" href="/nbd/conversions/edit/' . $conversion->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroyconversion" method="POST" onsubmit="return confirm(\'This action will delete this conversion.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $conversion->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }

            foreach($user->pipelines as $pipeline) {

                $datapipelines[] = [
                    $pipeline->customer,
                    $pipeline->address,
                    $pipeline->estimated_spend !== null ? number_format($pipeline->estimated_spend,0) : '',
                    $this->yesNo($pipeline->presentation),
                    $pipeline->comments,
                    Carbon::parse($pipeline->created_at)->format('m-d-y'),
                    '<a style="color: #9999B0;" href="/nbd/vendingpipeline/edit/' . $pipeline->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroypipeline" method="POST" onsubmit="return confirm(\'This action will delete this vending pipeline.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $pipeline->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }





        }




        $leadconfig = [
            'data' => $dataleads,
            'order' => [[7, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'columns' => [['orderable' => false], ['orderable' => false], null, ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<a href="#" style="color: #9999B0;"><i class="fas fa-pencil-alt"/></a>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<a href="#" style="color: #C78B8B;"><i class="fas fa-trash-alt"/></a>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => str_replace(' ', '', $salesperson) . '-Leads-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];

        $oppsconfig = [
            'data' => $dataopps,
            'order' => [[8, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'columns' => [['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => str_replace(' ', '', $salesperson) . '-Opportunities-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];


        $callsconfig = [
            'data' => $datacalls,
            'order' => [[5, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'columns' => [['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => str_replace(' ', '', $salesperson) . '-JointCalls-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];



        $conversionsconfig = [
            'data' => $dataconversions,
            'order' => [[7, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'columns' => [['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => str_replace(' ', '', $salesperson) . '-Conversions-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];



        $pipelinesconfig = [
            'data' => $datapipelines,
            'order' => [[5, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'columns' => [['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => str_replace(' ', '', $salesperson) . '-VendingPipeline-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];



        return view('nbd.admin.salesperson', compact('userquery', 'salesperson', 'leadheads', 'leadconfig', 'oppsheads', 'oppsconfig', 'callsheads', 'callsconfig', 'conversionsheads', 'conversionsconfig', 'pipelinesheads', 'pipelinesconfig'));
    }
    
}
