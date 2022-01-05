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




class MarkAsRead extends Controller
{
            public function MarkAsRead(Request $request){

                    $userunreadNotifications = Auth()->user()->unreadNotifications;

                    if ($userunreadNotifications ) {
                        $userunreadNotifications->markAsRead();
                        return back();
                    }
                        
                    
            }
}
