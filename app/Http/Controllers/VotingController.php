<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voting;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Auth;
use Illuminate\Support\Facades\DB;


class VotingController extends Controller
{
    public function index(){

        $from = date('Y');
        $to = date('Y-m-d H:m:s');
        error_log($to);
        if(isset($_GET["status"]) && $_GET['status']=="active"){
            return response()->json([
                "status" => 200,
                "message" => "Berhasil mengambil data voting!",
                "data" => Voting::where('voting_end', '>=', $to)->get()
            ], 200);
        }

        return response()->json([
            "status" => 200,
            "message" => "Berhasil mengambil data voting!",
            "data" => Voting::all()
        ], 200);
    }

    public function UserVote(Request $req)
{
    $token = explode(" ", $req->header("Authorization"))[1];
    $user = User::where("token", $token)->first();

    if (!$user) {
        return response()->json([
            "status" => 400,
            "message" => "Gagal mengambil data votingan!",
            "data" => null
        ], 400);
    }

    // Ambil semua data voting
    $votings = Voting::all();

    // Proses setiap voting
    $result = $votings->map(function ($voting) use ($user) {
        $userVote = collect($voting->data)->firstWhere('user_id', $user->id);

        $voteData = [
            "voteCount" => $voting->data ? count($voting->data) : 0,
            "candidate" => $userVote['candidate'] ?? null,
        ];

        return array_merge($voting->only(['voting_name', 'candidate', 'description', 'voting_start', 'voting_end']), [
            "id" => (string)$voting->_id,
            "data" => $voteData,
        ]);
    });

    return response()->json([
        "status" => 200,
        "message" => "Berhasil mengambil data voting!",
        "data" => $result
    ], 200);
}


    public function store(Request $req){
        try{

            $req->validate([
                "voting_name" => 'required',
                "voting_start" => 'required',
                "voting_end" => 'required',
                "description" => 'required',
                "candidate" => 'required'
            ]);


            foreach($req->candidate as $candidate){
                if(
                    count($req->candidate) < 2 ||
                    $candidate["name"] == "" || $candidate["name"] == NULL 
                    ){
                        return response()->json([
                            "status" => 400,
                            "message" => "Data kandidat tidak valid !"
                        ], 400);
                }
            }

            return response()->json([
                "status" => 200,
                "message" => "Berhasil menambahkan data voting !",
                "data" => Voting::create([
                    "voting_name" => $req->voting_name,
                    "voting_start" => $req->voting_start,
                    "voting_end" => $req->voting_end,
                    "description" => $req->description,
                    "candidate" => $req->candidate
                ])
            ], 200);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Data request tidak valid !"
            ], 400);
        }
    }

    public function update(Request $req){
        try{
            $newData = [];
            error_log($req->voting_name);

            $req->validate([
                "id" => 'required',
            ]);

            if($req->voting_name != NULL && $req->voting_name != "")$newData["voting_name"] = $req->voting_name;
            if($req->voting_start != NULL && $req->voting_start != "")$newData["voting_start"] = $req->voting_start;
            if($req->voting_end != NULL && $req->voting_end != "")$newData["voting_end"] = $req->voting_end;
            if($req->description != NULL && $req->description != "")$newData["description"] = $req->description;

            return response()->json([
                "status" => 200,
                "message" => "Berhasil memperbarui data voting !",
                "data" => Voting::where('id', $req->id)->update($newData)
            ], 200);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Id update tidak ditemukan !"
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
                "data" => Voting::where('id', $req->id)->delete()
            ], 200);

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Id tidak ditemukan !"
            ], 400);
        }
    }


    public function elect(Request $req){
        try{
            $req->validate([
                "voting_id" => 'required',
                "candidate" => 'required',
            ]);


            $user = User::where("token", explode(" ",$req->header('Authorization'))[1])->first();
            if( $user &&  Voting::where("id", $req->voting_id)->where("data.user_id",$user->id)->count() == 0 ){

                Voting::where("id", $req->voting_id)->update(array('$push' => array( "data" => [
                    "user_id" => $user->id,
                    "created_at" => date("Y-m-d H:m:s"),
                    "candidate" => (int)$req->candidate
                ])));

                return response()->json([
                    "status" => 200,
                    "message" => "Berhasil melakukan voting !",
                    "data" => $req
                ], 200);
            }else{
                return response()->json([
                    "status" => 401,
                    "message" => "Anda sudah memilih ! !",
                    "data" => NULL
                ],401);
            }

        }catch(ValidationException $e){
            return response()->json([
                "status" => 400,
                "message" => "Id tidak ditemukan !"
            ], 400);
        }
    }

    public function check(Request $req){
        return response()->json([
            "status" => 200,
            "message" => "Id tidak ditemukan !",
            "token" => explode(" ", $req->header('Authorization'))[1]
        ], 200);
    }
}
