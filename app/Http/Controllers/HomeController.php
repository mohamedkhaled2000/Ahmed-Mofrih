<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sections;
use App\invoices;
use App\invoices_details;
use App\invoice_attachments;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
           
        
$count_all= invoices::count();

$count_1= invoices::where('Value_Status',1)->count();
$count_1all=$count_1 / $count_all *100;

$count_2= invoices::where('Value_Status',2)->count();
$count_2all=$count_2 / $count_all *100;

$count_3= invoices::where('Value_Status',3)->count();
$count_3all=$count_3 / $count_all *100;














                $chartj = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 400, 'height' => 200])
                ->labels([' مدفوعه', 'مدفوعه جزئيا', 'غير مدفوعه'])
                ->datasets([
                        [
                            "label" => "نسبة الفواتير ",
                            'backgroundColor' => ['#f93a5a','#48d6a8','#f76a2d' ],
                          
                            
                           
                            'data' => [$count_1all, $count_2all,$count_3all],
                        ],
               
                ])
                ->options([]);


                        
                $chartjs = app()->chartjs
                ->name('barChartTest')
                ->type('bar')
                ->size(['width' => 400, 'height' => 200])
                ->labels([' مدفوعه', 'مدفوعه جزئيا', 'غير مدفوعه'])
                ->datasets([
                        [
                            "label" => "نسبة الفواتير ",
                            'backgroundColor' => ['#f93a5a','#48d6a8','#f76a2d' ],
                          
                            
                           
                            'data' => [$count_1all, $count_2all,$count_3all],
                        ],
               
                              
                      ])
                ->options([]);

                return view('home', compact('chartjs','chartj'));

    }
}
 // ->labels(['Label x','Label y'])
                // ->datasets([
                //     [
                //         "label" => "My First dataset",
                //         'backgroundColor' => ['#f93a5a','#48d6a8' ],// المدفوعه+المدفوعه جزئيا
                //         'data' => [$count_1all, 59]//نسبة المدفوعه+المدفوعه جزئيا
                //     ],
                //     [
                //         "label" => "My First dataset",
                //         'backgroundColor' => ['#f76a2d', '#005bea'],// غير مدفوعه +  جميع الفواتير 
                //         'data' => [65,15]//  نسبة غير مدفوعه +  جميع الفواتير 
                //     ]