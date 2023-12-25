<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\Req;

class ReqController extends Controller
{
    public function addOrder(Request $req)
    {
        Req::create([
            "phar_id" => $req->phar_id,
            "price" => $req->price
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

public function store(Request $request)
{
    $pharmacistId = $request->input('phar_id');

    // إنشاء الطلبية
    $order = Req::create([
        'phar_id' => $pharmacistId,
    ]);
    $order_id=Req::select("id")->where("phar_id",$order->phar_id);

    $medicines = $request->medicines; // قائمة الأدوية المُرسلة من الصيدلي

    foreach ($medicines as $medicine) {
        // البحث عن الدواء بالمعرف المرسل
        $selectedMedicine = Medication::findOrFail($medicine['id']);

        // إنشاء العلاقة وتعيين الكمية والمعلومات الإضافية
        $order->medications()->save($selectedMedicine,["name"=>$medicine["name"],"quan"=> $medicine["quan"]]);
    }

    return response()->json(['order' => $order], 201);
}



}
