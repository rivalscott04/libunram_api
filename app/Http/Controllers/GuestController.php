<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    public function index(){
        // $data = Guest::get();
        $data = DB::table('library_guest')
        ->join('member', 'library_guest.nim', '=', 'member.member_id')
        ->select(['library_guest.nim','member.member_name','library_guest.needs','library_guest.date_visit'])
        ->get();
        return view('app.guest',compact('data'));
    }
}
