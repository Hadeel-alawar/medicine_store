<?php

namespace App\Http\Controllers;


use App\Models\Medication;
use Illuminate\Http\Request;
use App\Models\Phar;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Illuminate\Support\Facades\Auth;

class PharController extends Controller
{
    public function reg(Request $req)
    {
        $rules = [
            "username" => 'required',
            "phone_number" => 'required|max:10|min:10|unique:phars,phone_number',
            "password" => 'required'
        ];
        $val = validator::make($req->all(), $rules);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "your data is invalid , try again",
                "errNum" => 44
            ]);
        }
        $phar = ([
            "username" => $req->username,
            "phone_number" => $req->phone_number,
            "password" => bcrypt($req->password)
        ]);
        Phar::create($phar);
        return response()->json([
            "ststus" => true,
            "messsage" => "your account created successfully",
            "statusNum" => 65
        ]);
    }

    public function login(Request $req)
    {
        $rules = [
            "username" => 'required',
            "phone_number" => 'required|max:10|min:10',
            "password" => 'required'
        ];
        $val = validator::make($req->all(), $rules);
        if ($val->fails()) {
            return response()->json([
                "status" => false,
                "message" => "your data is invalid , try again",
                "statusNum" => 8
            ]);
        }
        // $phar=$req->only("username","phone_number","password");
        $token = auth::guard("phar-api")->attempt($req->only("username", "phone_number", "password"));
        if ($token) {
            $pharmacist = auth::guard("phar-api")->user();
            $pharmacist->api = $token;
            return response()->json([
                "status" => true,
                "message" => "you are logged in successfully",
                "statusNum" => 10,
                "pharmacist" => $pharmacist
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "your data is invalid , try again",
                "statusNum" => 8
            ]);
        }
    }

    public function logout(Request $req)
    {
        $token = $req->header("token");
        if ($token) {
            try {
                JWTAuth::setToken($token)->invalidate();

            } catch (JWTException $e) {
                return response()->json([
                    "status" => false,
                    "message" => $e->getMessage(),
                    "statusNum" => 8
                ]);
            }
            return response()->json([
                "status" => true,
                "message" => "you are logged out",
                "statusNum" => 10
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "something went wrong",
            "statusNum" => 8
        ]);
    }

}

