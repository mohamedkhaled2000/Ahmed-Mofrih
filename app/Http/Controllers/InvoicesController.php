<?php

namespace App\Http\Controllers;
use App\User;
use App\sections;
use App\invoices;
use App\invoices_details;
use App\invoice_attachments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Addinvoices;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;


class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices= invoices::all();
    
        
        return view('invoices.invoices',compact('invoices'));

    }

   

    public function create()
    {
        $sections = sections::all();
        return view('invoices.add_invoices',compact('sections'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 3,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 3,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        //    $user = User::first();
        //    Notification::send($user, new AddInvoices($invoice_id));
       // event(new MyEventClass('hello world'));
      // $user = User::find(Auth::user()->id);// لو عاوز تبعته للمستخدم الي ضاف بس

        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

        
        session()->flash('Add');
        return redirect('/invoices');

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices= invoices::where('id',$id)->first();
        $sections=sections::all();
        
      

        return view('invoices.edit_invoices',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $id = $request->invoice_id;
       $invoices = invoices::where('id' , $id)->first();
       $Details = invoice_attachments::where('invoice_id', $id)->first();
      $id_page = $request->id_page;

            if (!$id_page== 2) {
        
                if (!empty($Details->invoice_number)) {

                    //لحذف الملف وترك الفولدر     Storage::disk('public_uploads')->delete($Details->invoice_number.'/'.$Details->file_name);
                        Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
                    }
                
                        $invoices->forceDelete();
                        //$invoices->Delete();
                        session()->flash('delete_invoice');
                        return redirect('/invoices');
             }else
             
             {
                  $invoices->delete();
                  session()->flash('Archive_invoice');
                  return redirect('/Archive_invoices');
             }
         
      }
     
   
   
   
   
   
    public function getproducts($id)
    {
       $products = DB::table("products")->where("section_id",$id)->pluck("product_name","id");
       return json_encode( $products);
    }

    public function Status($id)
    {
       
        $invoices= invoices::where('id',$id)->first();

        
        $sections=sections::all();
        
      

        return view('invoices.status_invoices',compact('invoices','sections'));

    }
    public function Status_Update($id,Request $request){
    //     $invoices = invoices::findOrFail($request->invoice_id);
    //     $invoices->update([
    //         'Status' => $request->Status,
    //         'Payment_Date' => $request->Payment_Date,
    
    //     ]);

        
    // }

    $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        elseif($request->Status === 'غير مدفوعه') {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);

            




        }else{

            $invoices->update([
                'Value_Status' => 2,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 2,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    public function paid(Request $request)
    {
        $invoices= invoices::where('Value_Status',1)->get();
        $sections=sections::all();
        
      

        return view('invoices.invoices_paid',compact('invoices','sections'));
       
    }
    
    public function unpaid(Request $request)
    {
        $invoices= invoices::where('Value_Status',3)->get();
        $sections=sections::all();
        
        return view('invoices.invoices_unpaid',compact('invoices','sections'));
       
    }
    public function  partial(Request $request)
    {
        $invoices= invoices::where('Value_Status',2)->get();
        $sections=sections::all();
        
        return view('invoices.invoices_partial',compact('invoices','sections'));
       
    }
    public function  print($id,Request $request)
    {
        $invoices= invoices::where('id',$id)->first();

        
        $sections=sections::all();
        
      

        return view('invoices.Print_invoices',compact('invoices','sections'));
        
       
    }


    public function export() 
    {
       return Excel::download(new InvoicesExport, 'قائمة الفواتير.xlsx');
    }
    
    

   
   
}