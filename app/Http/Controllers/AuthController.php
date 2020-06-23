<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' 		=> 'required',
            'email' 	=> 'required|unique:users',
            'address' 	=> 'required',
            'phone'	 	=> 'required|unique:users|numeric|min:11',
            'password' 	=> 'required|min:6',
            'role' 		=> 'required'
        ]);

        $name 	  = $request->input("name");
        $email 	  = $request->input("email");
        $password = $request->input("password");
        $address  = $request->input("address");
        $phone 	  = $request->input("phone");
        $role 	  = $request->input("role");

        $hashPwd = Hash::make($password);

        $data = [
            "name" 		=> $name,
            "email" 	=> $email,
            "password" 	=> $hashPwd,
            "address" 	=> $address,
            "phone" 	=> $phone,
            "role" 		=> $role
        ];

        if (User::create($data)) {
            $response = [
                "message" 	=> "register_success",
                "code"    	=> 201,
            ];
        } else {
            $response = [
                "message" 	=> "failed_regiser",
                "code"   	=> 404,
            ];
        }

        return response()->json($response, $response['code']);
    }

    public function login(Request $request)
    {
       $this->validate($request, [
            'password' => 'required|min:6'
        ]);

        $phone = $request->input("phone");

        $email = $request->input("email");

        $password = $request->input("password");

        $user = User::where("phone", $phone)
            ->orWhere("email", $email)->first();
        
        if (!$user) {
            $out = [
                "message" => "login failed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
            return response()->json($out, $out['code']);
        }
        if (!empty($request->input("email")) && !empty($request->input("phone"))) {
            $out = [
                "message" => "login failed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
        } else if (Hash::check($password, $user->password)) {
            $newtoken  = $this->generateRandomString();
 
            $user->update([
                'token' => $newtoken
            ]);

            $out = [
                "message" => "login_success",
                "code"    => 200,
                "result"  => [
                    "name"  => $user->name,  
                    "email" => $user->email,
                    "address" => $user->address,
                    "phone" => $user->phone,
                    "token" => $newtoken,
                ]
            ];
        } else {
            $out = [
                "message" => "login failed",
                "code"    => 401,
                "result"  => [
                    "token" => null,
                ]
            ];
        }
 
        return response()->json($out, $out['code']);
    }

    public function generateRandomString($length = 80)
    {
        $char = sha1(time());

        $str_char = strlen($char);
        
        $str = '';
        
        for ($i = 0; $i < $length; $i++) {
            $str .= $char[rand(0, $str_char - 1)];
        }
        return $str;
    }
}
