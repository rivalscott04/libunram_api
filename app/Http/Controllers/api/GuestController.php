<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    public function index(){
        // $data = Guest::with('member')->get();
        $data = DB::table('library_guest')
            ->join('member', 'library_guest.nim', '=', 'member.member_id')
            ->select(['library_guest.nim','member.member_name','library_guest.needs','library_guest.date_visit'])
            ->get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Guest',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Guest::where('id',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Guest Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Guest Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function getByDate($date){
        // return $date;
        // $data = Guest::where("(DATE_FORMAT(date_visit,'%Y-%m-%d'))",$date)->get();
        $data = DB::table("library_guest")
                ->join('member', 'library_guest.nim', '=', 'member.member_id')
                ->select(['library_guest.nim','member.member_name','library_guest.needs','library_guest.date_visit'])
                ->where(DB::raw("(DATE_FORMAT(date_visit,'%Y-%m-%d'))"),$date)
                ->get();
        // return $data;
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Guest Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Guest Not Found',
                'data' => null
            ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "nim" => "required",
            "needs" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
    
        $data = new Guest;
        $data->nim = $request->nim;
        $data->needs = $request->needs;
        $data->date_visit = Carbon::now()->format('Y-m-d H:i:s');
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Guest Created',
            'data' => $data
        ], 201);
    }
}
