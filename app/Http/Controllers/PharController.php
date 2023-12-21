<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\Phar;
use Validator;
class PharController extends Controller
{
    use ResponseTrait;
    public function reg(Request $req){
        $rules=[
            "username"=>'required',
            "phone_number"=>'required|max:10|min:10|unique:phars,phone_number',
            "password"=>'required'
        ];
        $val=validator::make($req->all(),$rules);
        if($val->fails()){
            return $this->error(55,"your data is invalid , enter your information again");
        }
        $phar=([
            "username"=>$req->username,
            "phone_number"=>$req->phone_number,
            "password"=>bcrypt($req->password)
        ]);
        Phar::create($phar);
        return "your account created successfully";
    }

    public function login(Request $req){
        $rules=[
            "username"=>'required',
            "phone_number"=>'required|max:10|min:10|unique:phars,phone_number',
            "password"=>'required'
        ];
        $val=validator::make($req->all(),$rules);
        if($val->fails()){
            return "your data is invalid , enter your information again";
        }



    }
}
