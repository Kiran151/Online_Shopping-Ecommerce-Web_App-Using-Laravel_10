<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use DateTime;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function reports()
    {

        return view('admin.report.report_view');
    }


    public function searchByDate(Request $request)
    {
        $date = $request->date;
        $data=Order::where('order_date',$date)->get();
        return view('admin.report.report_view',compact('data','date'));

    }

    public function searchByMonth(Request $request){
        $month = $request->month;
        $year= $request->month_year;
        if($year!==null){
            $data=Order::where([['order_month',$month],['order_year',$year]])->get();
            return view('admin.report.report_view',compact('data','month','year'));
        }else{
            $data=Order::where('order_month',$month)->get();
            return view('admin.report.report_view',compact('data','month'));
        }
       
    }
    public function searchByYear(Request $request){
        $year = $request->year;
        $data=Order::where('order_year',$year)->get();
        return view('admin.report.report_view',compact('data','year'));
    }
}