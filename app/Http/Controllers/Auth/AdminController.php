<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Auth; 

class AdminController extends Controller
{
     //Fungsi menampilkan halaman admin
    public function index(){
        if(Auth::user()->role == NULL || Auth::user()->role != "admin"){
            return redirect("/");
        }
        $to = date('Y-m-d H:m:s');

        $stat = [
            "totalVotingan" => Voting::count(),
            "votinganEnd" => Voting::where('voting_end', '<', $to)->count(),
            "votinganLive" => Voting::where('voting_end', '>=', $to)->count()
        ];

        $username = Auth::user()->username;

        return View('admin', compact(['stat', 'username']));
    }

    public function store(){
        if(!User::where("username", "admin")->count()){
            User::create([
                "username" => "admin",
                "password" => Hash::make("admin"),
                "email" => "admin@gmail.com",
                "role" => "admin"
            ]);
        }else{
            User::where("username", "admin")->update([
                "username" => "admin",
                "password" => Hash::make("admin"),
                "email" => "admin@gmail.com",
                "role" => "admin"
            ]);
        }

        return redirect("/");
    }
}
