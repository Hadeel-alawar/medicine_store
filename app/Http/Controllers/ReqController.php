<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Req;

class ReqController extends Controller
{
    public function addOrder(Request $req)
    {
        // Req::create([
        //     "phar_id" => $req->phar_id,
        //     // "price" =>$req->price
        // ]);
        // $req_id = Req::latest()->value("id");
        // $request = Req::where("id", $req_id)->first();
        // for ($i = 0; $i < count($req->medicine_id); $i++) {
        // $request->medications()->attach([
        //         $request->medicine_id[$i] => [
        //             "name" => $req->name[$i],
        //             "quantity" => $req->quantity[$i]
        //         ]
        //     ]);
        // }
        Req::create([
            "phar_id" => $req->phar_id,
            "price"=>$req->price
        ]);
        $or_id = Req::max("id");
        $request = Req::where("id", $or_id)->first();
        // return count($req->medicine_ids);
        for ($i = 0; $i < count($req->medicine_ids); $i++) {
            $request->medications()->attach([
                $req->medicine_ids[$i] => [
                    "name" => $req->name[$i],
                    "quantity" => $req->quan[$i]
                ]
            ]);
        }
        return response()->json([
            "status" => true,
            "message" => "the request is sent",
            "statusNum" => 8
        ]);
    }


}
