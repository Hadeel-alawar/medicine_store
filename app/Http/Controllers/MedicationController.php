<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use PHPUnit\Framework\Constraint\IsEmpty;
use Validator;

class MedicationController extends Controller
{
    public function addMedication(Request $request)
    {
        $med = Medication::where("scientific_name", $request->s_name)->first("quantity");
        if ($med) {
            $med->quantity += $request->quan;
            Medication::where("scientific_name", $request->s_name)->update([
                "quantity" => $med->quantity
            ]);
            return response()->json([
                "status" => true,
                "message" => "this medicine is really exist , but its quantity is increased",
                "statusNum" => 10
            ]);
        } else {
            Medication::create([
                "scientific_name" => $request->s_name,
                "commercial_name" => $request->c_name,
                "cat" => $request->cat,
                "manufacturer" => $request->manu,
                "quantity" => $request->quan,
                "expire_date" => $request->ex_date,
                "price" => $request->price
            ]);
            return response()->json([
                "status" => true,
                "message" => "the medications added successfully",
                "statusNum" => 10
            ]);
        }
    }

    public function browse()
    {
        $medicinesByCategory = Medication::select('cat')->distinct()
            ->orderBy('cat')
            ->get();

        $medicinesGroupedByCategory = [];

        foreach ($medicinesByCategory as $category) {
            $medicinesGroupedByCategory[$category->cat] = Medication::where('cat', $category->cat)->get();
        }

        return response()->json(['medicinesByCategory' => $medicinesGroupedByCategory], 200);
    }




    // public function browse()
    // {
    //     $med = Medication::get()->groupby("cat");
    //     return response()->json([
    //         "status" => true,
    //         "message" => "this is your medicines",
    //         "statusNum" => 10,
    //         "medications" => $med
    //     ]);
    // }

    // public function search(Request $request)
    // {
    //     $med = Medication::where("cat", $request->input)
    //         ->orwhere("scientific_name", $request->input)
    //         ->get();
    //     if (!empty($med)) {
    //         return response()->json([
    //             "status" => true,
    //             "message" => "the result",
    //             "statusNum" => 10,
    //             "medications" => $med
    //         ]);
    //     } else {
    //         return response()->json([
    //             "status" => false,
    //             "message" => "not found",
    //             "statusNum" => 8
    //         ]);
    //     }
    // }


    public function search(Request $request)
    {
        $input = $request->input('input');

        $medicines = Medication::where('cat', 'like', '%' . $input . '%')
            ->orWhere('scientific_name', 'like', '%' . $input . '%')
            ->get();

        if (!$medicines->isEmpty()) {
            return response()->json([
                "status" => true,
                "message" => "the result",
                "statusNum" => 10,
                "medications" => $medicines
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "not found",
                "statusNum" => 8
            ]);
        }
    }


    public function viewSpecifics($id)
    {
        $med = Medication::find($id);
            return response()->json([
                "status" => true,
                "message" => "this is the medicine",
                "statusNum" => 10,
                "medications" => $med
            ]);
    }
}
