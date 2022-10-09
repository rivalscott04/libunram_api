<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index(){
        $data = Item::get();
        return response()->json([
            'status' => 'success',
            'message' => 'List Of Item',
            'data' => $data
        ], 200);
     }
 
    public function get($id){
        $data = Item::where('item_code',$id)->first();
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

    public function getByItem(Request $request){
        $validator = Validator::make($request->all(),[
            "item_code" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'Error',
                'message' => $validator->messages()->all()
            ],500);
        }

        $data = Item::where('item_code',$request->item_code)->with('biblio')->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Detail Item Found',
                'item_code' => $data->item_code,
                'title' => $data->biblio->title,
                'publihser_name' => $data->biblio->publisher->publisher_name,
                'publish_year' => $data->biblio->publish_year
            ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Detail Item Not Found',
                'data' => null
            ], 404);
        }
    }
}
