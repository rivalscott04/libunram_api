<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    public function index(){
        $data = Visitor::limit(25)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Visitor',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Visitor::where('visitor_id',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Visitor Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Visitor Not Found',
                'data' => null
            ], 404);
        }
    }
 
    public function getByMemberId($member_id){
        $data = Visitor::where('member_id',$member_id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Visitor Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Visitor Not Found',
                'data' => null
            ], 404);
        }
    }

    public function getByRoom($tgl){
        // return 'tes';
        // $date = Carbon::now()->format('Y-m-d');
        $data = DB::table("visitor_count")
        ->join('room', 'visitor_count.id_ruangan', '=', 'room.id_ruangan')
        ->where(DB::raw("(DATE_FORMAT(checkin_date,'%Y-%m-%d'))"),$tgl)
        ->get();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Visitor Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Visitor Not Found',
                'data' => null
            ], 404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "member_id" => "required",
            "member_name" => "required",
            "institution" => "required",
            "id_ruangan" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }

        // return $request->id_ruangan;

        $date = Carbon::now()->format('Y-m-d');
        $visitor = DB::table("visitor_count")
        ->where(DB::raw("(DATE_FORMAT(checkin_date,'%Y-%m-%d'))"),$date)
        ->where('member_id',$request->member_id)
        ->where('id_ruangan',$request->id_ruangan)
        ->first();

        // return $visitor;
        if ($visitor){
            return response()->json([
                'status' => 'error',
                'message' => 'Anda Sudah Mengisi Buku Tamu',
                'data' => $visitor
            ], 404);
        }

        if (Room::all()->where('id_ruangan', $request['id_ruangan'])->count()==0){
            return response()->json([
                'status' => 'error',
                'message' => 'Ruangan Tidak Ditemukan',
                'data' => $visitor
            ], 404);
        }
        
        $data = new Visitor;
        $data->member_id = $request->member_id;
        $data->member_name = $request->member_name;
        $data->institution = $request->institution;
        $data->id_ruangan = $request->id_ruangan;
        $data->checkin_date = Carbon::now()->format('Y-m-d H:i:s');
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Visitor Created',
            'data' => $data
        ], 201);
    }
}
