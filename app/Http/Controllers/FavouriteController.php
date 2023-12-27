<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FavouriteController extends Controller
{
    public function addFav(Request $request)
    {
        $phar_id = $request->phar_id;
        Favourite::create([
            "phar_id" => $phar_id
        ]);

        $fav_id = Favourite::latest()->value("id");
        // return $fav_id;
        $fav = Favourite::find($fav_id);
        // return $fav;
        $medicine_ids = $request->medicine_Ids;
        // return $medicine_ids;
        foreach ($medicine_ids as $key => $medicineId) {
            $fav->medications()->attach($medicineId, [
                'created_at' => Carbon::now(),

                'updated_at' => Carbon::now(),
            ]);
            // return $medicineId;
        }

    }
}
