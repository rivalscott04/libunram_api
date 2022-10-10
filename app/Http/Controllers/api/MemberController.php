<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    //

    public function index(){
        $data = Member::all();
        return $data;
    }

    public function get($id){
        $data = Member::where('member_id',$id)->first();
        // dd($id);
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Member Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Data Member Not Found',
                'data' => null
            ], 404);
        }
    }

    
}
