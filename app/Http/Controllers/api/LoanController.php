<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index(){
        $data = Loan::limit(25)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Loan',
            'data' => $data
        ], 200);
     }

     public function getByIdMember(Request $request){
        $validator = Validator::make($request->all(),[
            "member_id" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
       
        $data = Loan::where('member_id',$request->member_id)->with('item')->orderBy('loan_date','desc')->limit(25)->get();
        // return $loan;
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Item Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Item Not Found',
                'data' => null
            ], 404);
        }
     }

     public function getHistory(Request $request){
        $validator = Validator::make($request->all(),[
            "member_id" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }
       
        $data = Loan::where('member_id',$request->member_id)->where('is_return','=','1')->with('item')->orderBy('loan_date','desc')->limit(25)->get();
        // return $loan;
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Hitory Found',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Hitory Not Found',
                'data' => null
            ], 404);
        }
     }

     public function store(Request $request){
        $validator = Validator::make($request->all(),[
            "item_code" => "required",
            "member_id" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }

        $today = Carbon::now()->format('Y-m-d');
        $date = new DateTime($today);
        $client = new Client();
        $response = $client->request('GET','https://data.if.unram.ac.id/libunram/config.json');
        $content = $response->getBody()->getContents();
        $data = json_decode($content);
        $addDay = '+'.$data->due_date.' day';
        // $tanggal = $date->modify($addDay)->format('Y-m-d');
        // return $addDay;
        $item = Item::where('item_code',$request->item_code)->first();
        if(!$item){
            return response()->json([
                'status' => 'Error',
                'message' => 'Buku Tidak Tersedia',
                'data' => null
            ], 404);
        }

        $loan = Loan::where('is_lent','=','1')->where('is_return','=','0')->where('item_code',$request->item_code)->first();
        if($loan){
            return response()->json([
                'status' => 'Error',
                'message' => 'Buku Sudah DiPinjam',
                'data' => $loan
            ], 404);
        }

        $limit = DB::table("mst_member_type")
        ->select('loan_limit')
        ->first();
        // return $limit->loan_limit;

         $history = Loan::where('member_id',$request->member_id)->where('is_return','=','0')->limit(25)->get();
        //  return count($history);

        if($limit->loan_limit == count($history)){
            return response()->json([
                'status' => 'Error',
                'message' => 'Kuota Peminjaman Sudah Penuh',
                'data' => null
            ], 404);
        }

    
        $data = new Loan;
        $data->item_code = $request->item_code;
        $data->member_id = $request->member_id;
        $data->loan_date = $today;
        $data->due_date = $date->modify($addDay)->format('Y-m-d');
        $data->input_date = Carbon::now()->format('Y-m-d H:i:s');
        $data->last_update= Carbon::now()->format('Y-m-d H:i:s');
        $data->is_lent = 1;
        $data->is_return = 0;
        $data->uid = null;
        $data->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'New Loan Created',
            'data' => $data
        ], 201);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "item_code" => "required",
            "member_id" => "required",
            "loan_date" => "required",
            "due_date" => "required",
            "is_lent" => "required",
            "is_return" => "required",
            "uid" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all(),
            ],500);
        }
        
        $data = Loan::firstWhere('loan_id',$id);
        // return $data;
        if ($data){
            $data->item_code = $request->item_code;
            $data->member_id = $request->member_id;
            $data->loan_date = $request->loan_date;
            $data->due_date = $request->due_date;
            $data->is_lent = $request->is_lent;
            $data->is_return = $request->is_return;
            $data->uid = $request->uid;
            $data->update();
            return response()->json([
                'status' => 'success',
                'message' => 'Loan Updated',
                'data' => $data
            ], 201);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Loan Not Found',
                'data' => null
            ], 404);
        }
    }
    
    public function destroy($id){
        $data = Loan::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Detail Loan Deleted',
            'data' => null
        ], 201);
    }
}


