<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(){
        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengambil data user !",
            "data" => User::all(),
        ],200);
    }

    public function store(Request $req){
        try{

            $data = $req->validate([
                "username" => 'required',
                "password" => 'required',
            ]);
        

            return response()->json([
                "status" => 200,
                "message" => "Berhasil menambahkan data pengguna!",
                "data" => User::create([
                    "username" => $req->username,
                    "password" => Hash::make($req->password),
                    "email" => $req->email ?? $req->username."@gmail.com",
                    "role" => $req->role ?? "user"
                ], 200)
            ]);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Gagal menambahkan data pengguna ! Field tidak lengkap !",
                "data" => NULL
            ], 400 );
        }
    }

    public function login(Request $req){
        try{
            $body = $req->validate([
                "username" => 'required',
                "password" => 'required'
            ]);

            if(Auth::attempt($req->only('username', 'password'))){
                Auth::guard(Auth::user()->role??"user" == "admin" ? "admin" : "web")->attempt($req->only('username', 'password'));
                $token = $req->user()->createToken("api-token")->plainTextToken;
                $user = User::where("username", $req->username)->update(["token" => $token]);
                Auth::user()->role = $user->role ?? "user";
                
                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil login !",
                    "data" => [
                        "token" => $token,
                        "user" => Auth::user(),
                    ]
                ], 200 );
               
                
            }else{
                return response()->json([
                    "status" => 401,
                    "message" => "Username atau password salah !",
                    "data" => NULL
                ], 401 );
            }

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Username atau password kosong !",
                "data" => NULL
            ], 400 );
        }
    }

    public function update(Request $req){
        try{
            $updateData = [];

            $req->validate([
                "id" => 'required',
            ]);

            if($req->username != NULL && $req->username != "") $updateData["username"] = $req->username;
            if($req->password != NULL && $req->password != "") $updateData["password"] = $req->password;
            if($req->email != NULL && $req->email != "") $updateData["email"] = $req->email;
            if($req->role != NULL && $req->role != "") $updateData["role"] = $req->role;

            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengupdate data user !",
                "data" => User::where("id", $req->id)->update($updateData)
            ], 200);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Id tidak ditemukan !"
            ], 400);
        }
    }

    public function destroy(Request $req){
        try{

            $req->validate([
                "id" => 'required',
            ]);

            return response()->json([
                "status" => 200,
                "message" => "Berhasil menghapus data voting !",
                "data" => User::where('id', $req->id)->delete()
            ], 200);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Id tidak ditemukan !"
            ], 400);
        }
    }

    public function ses(){
        return response()->json([
            "data" => Auth::check()
        ],200);
    }
}
