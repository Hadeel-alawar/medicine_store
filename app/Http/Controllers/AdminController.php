<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
class AdminController extends Controller
{
    public function addMedication(Request $request){
        Medication::create([
            "scientific_name"=>$request->s_name,
            "commercial_name"=>$request->c_name,
            "cat"=>$request->cat,
            "manufacturer"=>$request->manu,
            "quantity"=>$request->quan,
            "expire_date"=>$request->ex_date,
            "price"=>$request->price
        ]);
        return response()->json([
            "status" => true,
            "message" => "the medications added successfully",
            "statusNum" => 10
        ]);
    }
}
