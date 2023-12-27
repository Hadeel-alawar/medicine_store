<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\Req;
use Illuminate\Support\Carbon;

class ReqController extends Controller
{
    public function addOrder(Request $request)
    {
        $amounts = array_filter($request->quan);
        $ids = $request->medicine_Ids;
        $price = 0;
        for ($i = 0; $i < count($amounts); $i++) {
            $currnetPrice = Medication::find($ids[$i])->price;
            $price += $currnetPrice * $amounts[$i];
        }
        Req::create([
            "phar_id" => $request->phar_id,
            "price" => $price
        ]);
        $order_id = Req::latest()->value('id');
        $order = Req::find($order_id);
        foreach ($request->medicine_Ids as $key => $medicineId) {
            $medicine = Medication::find($medicineId);
            $order->medications()->attach($medicineId, [
                'quantity' => $amounts[$key],
                'price' => $medicine->price,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        $receive_status = $request->receive;
        $payment_status = $request->payment;
        for ($i = 0; $i < count($request->req_ids); $i++) {
            if ($receive_status[$i] != null) {
                Req::where("id", $request->req_ids[$i])->update([

                    "receive_state" => $receive_status[$i]
                ]);
                if ($receive_status[$i] == "sent") {
                    $order_id = $request->req_ids[$i];
                    $order = Req::find($order_id);
                    $meds = $order->medications;
                    foreach ($meds as $med) {
                        $med_id = $med->id;
                        $med_quan = $order->medications()->where("medication_id", $med_id)->first()->pivot->quantity;
                        Medication::where("id", $med_id)->update([
                            "quantity" => ($med->quantity - $med_quan)
                        ]);

                    }

                }

            }
            if ($payment_status[$i] != null) {
                Req::where("id", $request->req_ids[$i])->update([
                    "payment_state" => $payment_status[$i]
                ]);
            }
        }
    }


    public function report(Request $request){

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $orders = Req::whereBetween('created_at', [$startDate, $endDate])->get();
        // $med=$orders->medications;
        $sales = Req::where("receive_state","sent")->whereBetween('created_at' , [$startDate, $endDate])->get();
        return response()->json([
            "status" => true,
            "message" => "this is a report which view the orders and the sales in a specefic period",
            "statusNum" => 10 ,
            "orders in this period " => $orders,
            "sales in this period " => $sales
        ]);
    }


}



