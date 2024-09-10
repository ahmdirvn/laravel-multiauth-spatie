<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class borrowingController extends Controller
{
    //
    public function index(){
        $dept = DB::table('department')->whereNull('deleted_at')->get();
        return view('Borrowing')->with('dept',$dept);
    }

}
