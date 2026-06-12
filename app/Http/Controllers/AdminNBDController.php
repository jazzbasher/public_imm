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


    /**********************************************************************************************
     * ********************************************************************************************
     * ***********************     Admin Dash Panel     *******************************************
     * ********************************************************************************************
     * *******************************************************************************************/


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




    /**********************************************************************************************
     * ********************************************************************************************
     * *********************     Custom Boolean Return Function     *******************************
     * ********************************************************************************************
     * *******************************************************************************************/


    public function yesNo($value)
    {
        return $value ? 'Yes' : 'No';
    }



    /**********************************************************************************************
     * ********************************************************************************************
     * *********************         Admin Dash Data By Category      *****************************
     * ********************************************************************************************
     * *******************************************************************************************/


    public function adminleads()
    {
        $customerleads = NewCustomerLeads::where('active', 1)->with('user')->get();

        $userleads = User::where('is_sales', 1)->withCount(['newcustomerleads' => function ($query) {
            $query->where('active', 1);
        }])->get();

        $userleadscontact = User::where('is_sales', 1)->withCount(['newcustomerleads' => function ($query) {
            $query->where('active', 1)->where('contact_made', 1);
        }])->get();


        $datechart = NewCustomerLeads::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month') // Key is month number (1-12), value is the count
            ->toArray();


        $pieleads = $userleads->pluck('newcustomerleads_count', 'name');
        $barcontacts = $userleadscontact->pluck('newcustomerleads_count', 'name');



        $monthlabels = [];
        $monthdata = [];

         $currentMonth = Carbon::now()->month;
    for ($m = 1; $m <= $currentMonth; $m++) {
        // Format the month index to a short name string (e.g., Jan, Feb)
        $monthlabels[] = Carbon::create()->month($m)->format('M');
        
        // Use the count from database, or fallback to 0 if the month had no entries
        $monthdata[] = $datechart[$m] ?? 0;
    }



        $userlabel = [];
        $leadsdata = [];
        $usercontactlabel = [];
        $contactdata = [];


        foreach($pieleads as $k => $v){
        $userlabel[] = $k;
        $leadsdata[] = $v;
        }


        foreach($barcontacts as $k => $v){
        $usercontactlabel[] = strtok($k, " ");
        $contactdata[] = $v;
        }

        $heads = ['Sales','Lead', 'Address', 'Planned', 'Contact?', 'Name', 'email', 'Notes', 'Created', '', ''];
        $data = [];

        foreach($customerleads as $lead) {

            $data[] = [
                strtok($lead->user->name, " "),
                $lead->new_lead,
                $lead->address,
                Carbon::parse($lead->date_planned)->format('m-d-y'),
                $this->yesNo($lead->contact_made),
                $lead->contactname,
                $lead->email,
                $lead->comments,
                Carbon::parse($lead->created_at)->format('m-d-y'),
                '<a class=btn btn-link" style="color: #9999B0;" href="/nbd/newleads/edit/' . $lead->id . '"><i class="fas fa-pencil-alt"/></a>',

                '<form action="/admin/destroylead" method="POST" onsubmit="return confirm(\'This action will delete this lead.  Are you sure?\');">' .
                '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                '<input type="hidden" name="id" value ="' . $lead->id . '">' .
                '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                '</form>',

                ];
            }


            $config = [
            'data' => $data,
            'order' => [[0, 'asc'],[8, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'language' => ['emptyTable' => "No Customer Leads"],
            'columns' => [null,['orderable' => false], ['orderable' => false], null, ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<a href="#" style="color: #9999B0;"><i class="fas fa-pencil-alt"/></a>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<a href="#" style="color: #C78B8B;"><i class="fas fa-trash-alt"/></a>', 'orderable' => false]],
                'buttons' =>  [
                        [ 
                            'extend' => 'excelHtml5',
                            'text' => '<i class="fas fa-file-excel"></i>',
                            'className' => 'btn btn-success',
                            'titleAttr' => 'Excel Export',
                            'filename' => '-Leads-' . today()->format('y-m-d'), 
                        ],
                        [ 
                            'extend' => 'print',
                            'text' => '<i class="fas fa-print"></i>',
                            'className' => 'btn btn-success',
                            'titleAttr' => 'Print',
                        ],
                ]
            ];


        return view('nbd.admin.admincustomerleads', compact('heads', 'config', 'userlabel', 'leadsdata', 'usercontactlabel', 'contactdata', 'monthlabels', 'monthdata'));

    }





    public function adminopp()
    {
        $opps = NewOpportunities::where('active', 1)->with('user')->get();

        $useropps = User::where('is_sales', 1)->withCount(['newopps' => function ($query) {
            $query->where('active', 1);
        }])->get();

        $userquotes = User::where('is_sales', 1)->withCount(['newopps' => function ($query) {
            $query->where('active', 1)->where('quote', 1);
        }])->get();

        $uservalue = User::where('is_sales', 1)->withSum(['newopps' => function ($query) {
            $query->where('active', 1);
        }], 'projected_value')->get();



        $pieopps = $useropps->pluck('newopps_count', 'name');
        $barquote = $userquotes->pluck('newopps_count', 'name');
        $polarvalue = $uservalue->pluck('newopps_sum_projected_value', 'name');


        $userlabel = [];
        $oppsdata = [];
        $userquotelabel = [];
        $quotedata = [];
        $valuelabel = [];
        $valuedata = [];
        $dataopps = [];


        foreach($pieopps as $k => $v){
        $userlabel[] = $k;
        $oppsdata[] = $v;
        }


        foreach($barquote as $k => $v){
        $userquotelabel[] = strtok($k, " ");
        $quotedata[] = $v;
        }

        foreach($polarvalue as $k => $v){
        $valuelabel[] = strtok($k, " ");
        $valuedata[] = $v;
        }



        $heads = ['Sales','Customer', 'Interest', 'Quote?', 'Value', 'Projected', 'Confidence', 'Rep', 'Notes', 'Created', '', ''];
        $data = [];


        foreach($opps as $opp) {

                $dataopps[] = [
                    strtok($opp->user->name, " "),
                    $opp->customer,
                    $opp->interest,
                    $this->yesNo($opp->quote),
                    $opp->projected_value !== null ? number_format($opp->projected_value,0) : '',
                    Carbon::parse($opp->close_date)->format('m-d-y'),
                    $opp->confidence,
                    $opp->rep,
                    $opp->comments,
                    Carbon::parse($opp->created_at)->format('m-d-y'),
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/newopportunities/edit/' . $opp->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroyopportunity" method="POST" onsubmit="return confirm(\'This action will delete this opportunity.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $opp->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }


            $oppsconfig = [
            'data' => $dataopps,
            'order' => [[0, 'asc'],[9, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'language' => ['emptyTable' => "No New Opportunties"],
            'columns' => [null,['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['orderable' => false], ['orderable' => false], ['orderable' => false], null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => '-Opportunities-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];


        return view('nbd.admin.adminopportunity', compact('heads', 'oppsconfig', 'userlabel', 'oppsdata', 'userquotelabel', 'quotedata', 'valuelabel', 'valuedata'));

    }




    public function adminpipeline()
    {

        $pipelines = VendingPipeline::where('active', 1)->with('user')->get();

        $userpipelines = User::where('is_sales', 1)->withCount(['pipelines' => function ($query) {
            $query->where('active', 1);
        }])->get();

        $userpresentations = User::where('is_sales', 1)->withCount(['pipelines' => function ($query) {
            $query->where('active', 1)->where('presentation', 1);
        }])->get();

        $spendvalue = User::where('is_sales', 1)->withSum(['pipelines' => function ($query) {
            $query->where('active', 1);
        }], 'estimated_spend')->get();


        $piepipelines = $userpipelines->pluck('pipelines_count', 'name');
        $barpresentations = $userpresentations->pluck('pipelines_count', 'name');
        $chartspent = $spendvalue->pluck('pipelines_sum_estimated_spend', 'name');



        $userlabel = [];
        $pipelinedata = [];
        $userpreslabel = [];
        $presdata = [];
        $spendlabel = [];
        $spenddata = [];
        $datapipelines = [];


        foreach($piepipelines as $k => $v){
        $userlabel[] = $k;
        $pipelinedata[] = $v;
        }


        foreach($barpresentations as $k => $v){
        $userpreslabel[] = strtok($k, " ");
        $presdata[] = $v;
        }

        foreach($chartspent as $k => $v){
        $spendlabel[] = strtok($k, " ");
        $spenddata[] = $v;
        }



        $heads = ['Sales','Customer', 'Address', 'EstimatedSpend', 'Presentation', 'Notes', 'Created', '', ''];
        $data = [];


        foreach($pipelines as $pipeline) {

                $datapipelines[] = [
                    strtok($pipeline->user->name, " "),
                    $pipeline->customer,
                    $pipeline->address,
                    $pipeline->estimated_spend !== null ? number_format($pipeline->estimated_spend,0) : '',
                    $this->yesNo($pipeline->presentation),
                    $pipeline->comments,
                    Carbon::parse($pipeline->created_at)->format('m-d-y'),
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/vendingpipeline/edit/' . $pipeline->id . '"><i class="fas fa-pencil-alt"/></a>',

                    '<form action="/admin/destroypipeline" method="POST" onsubmit="return confirm(\'This action will delete this vending pipeline.  Are you sure?\');">' .
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                    '<input type="hidden" name="id" value ="' . $pipeline->id . '">' .
                    '<button type="submit" class="btn btn-link"><i style="color: #C78B8B" class="fas fa-trash-alt"/></button>' .
                    '</form>',
                ];
            }



            $pipelinesconfig = [
            'data' => $datapipelines,
            'order' => [[0, 'asc'],[6, 'desc']],
            'responsive' => true,
            'paging' => false,
            'info'  => false,
            'language' => ['emptyTable' => "No New Pipelines"],
            'columns' => [null,['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false], ['orderable' => false],  null, ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-pencil-alt"/>', 'orderable' => false], ['className' => 'dt-center editor-edit', 'defaultContent' => '<i class="fas fa-trash-alt"/>', 'orderable' => false]],
            'buttons' =>  [
                [ 
                    'extend' => 'excelHtml5',
                    'text' => '<i class="fas fa-file-excel"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Excel Export',
                    'filename' => '-Opportunities-' . today()->format('y-m-d'), 
                ],
                [ 
                    'extend' => 'print',
                    'text' => '<i class="fas fa-print"></i>',
                    'className' => 'btn btn-success',
                    'titleAttr' => 'Print',
                ],
            ]
        ];


        return view('nbd.admin.adminpipelines', compact('heads', 'pipelinesconfig', 'userlabel', 'pipelinedata', 'userpreslabel', 'presdata', 'spendlabel', 'spenddata'));


    }




    /**********************************************************************************************
     * ********************************************************************************************
     * *********************     Admin Dash Data By User/Salesperson  *****************************
     * ********************************************************************************************
     * *******************************************************************************************/



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
                '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/newleads/edit/' . $lead->id . '"><i class="fas fa-pencil-alt"/></a>',

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
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/newopportunities/edit/' . $opps->id . '"><i class="fas fa-pencil-alt"/></a>',

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
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/jointcalls/edit/' . $calls->id . '"><i class="fas fa-pencil-alt"/></a>',

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
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/conversions/edit/' . $conversion->id . '"><i class="fas fa-pencil-alt"/></a>',

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
                    '<a  class=btn btn-link" style="color: #9999B0;" href="/nbd/vendingpipeline/edit/' . $pipeline->id . '"><i class="fas fa-pencil-alt"/></a>',

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
            'language' => ['emptyTable' => "No Customer Leads"],
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
            'language' => ['emptyTable' => "No New Opportunties"],
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
            'language' => ['emptyTable' => "No Joint Calls"],
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
            'language' => ['emptyTable' => "No Conversions"],
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
            'language' => ['emptyTable' => "No Vending Pipelines"],
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
