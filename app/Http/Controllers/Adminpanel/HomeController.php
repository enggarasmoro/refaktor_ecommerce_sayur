<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Dashboard';
        $totalordermasuk = DB::table('order')->where('status', 0)->where('created_at', 'like', '%'.date("Y-m").'%')->count();
        $totalorderproses = DB::table('order')->where('status', 1)->where('created_at', 'like', '%'.date("Y-m").'%')->count();
        $order      = DB::table('order')
                        ->select(DB::raw('SUM(total) as total'))
                        ->whereIn('status',['1','2'])
                        ->where('created_at', 'like', '%'.date("Y-m").'%')->first();
        $bulan = date("M Y");
        return view('backoffice.home.index',compact('title','totalordermasuk','totalorderproses','order','bulan'));
    }
}
