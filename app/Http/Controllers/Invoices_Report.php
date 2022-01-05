<?php

namespace App\Http\Controllers;
use App\sections;
use App\invoices;
use App\invoices_details;
use App\invoice_attachments;
use Illuminate\Http\Request;

class Invoices_Report extends Controller
{
        public function report(Request $request) 
        {
            $id = $request->invoice_id;
            $invoices= invoices::where('id',$id)->get();

            
            $sections=sections::all();
            
        

            return view('reports.invoices_report',compact('invoices','sections'));
            
        }

      



        public function Search_invoices(Request $request){
                    $rdio = $request->rdio;

                    if ($rdio == 1) {

                        
                         if($request->type=='جميع الفواتير' &&$request->start_at =='' && $request->end_at ==''){ 
                            $invoices = invoices::all();
                            $type= $request->type;
                            return view('reports.invoices_report',compact('type'))->withDetails($invoices);

                            }

                            //في حالة عدم تحديد تاريخ
                       
                            elseif ($request->type && $request->start_at =='' && $request->end_at =='' ) {
                                $invoices = invoices::select('*')->where('Status','=',$request->type)->get();
                                $type= $request->type;
                                return view('reports.invoices_report',compact('type'))->withDetails($invoices);


                                
                            }
                            
                            
                             //في حالة  تحديد تاريخ
                            else{
                                
                                $start_at = date($request->start_at);
                                $end_at = date($request->end_at);
                                $type = $request->type;
                                $invoices = invoices::whereBetween('invoice_Date',[ $start_at , $end_at])->where('Status','=',$request->type)->get();
                                
                                return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);



                            }
                    }
                    else{
                        $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
                                
                        return view('reports.invoices_report')->withDetails($invoices);

                    }


        }





        public function customers_report(){
            $invoices= invoices::all();
            $sections=sections::all();
                
            
        
            return view('reports.customers_report',compact('invoices','sections'));
    
    
        }



        public function Search_customers(Request $request){

            if ($request->Section &&$request->product && $request->start_at =='' && $request->end_at =='' ) {
                $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
                $sections=sections::all();
               
                return view('reports.customers_report',compact('sections'))->withDetails($invoices);


                
            }
            else{

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;
                $sections=sections::all();
                $invoices = invoices::whereBetween('invoice_Date',[ $start_at , $end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
                
                return view('reports.customers_report',compact('sections','start_at','end_at'))->withDetails($invoices);
              

            }

        }
}
