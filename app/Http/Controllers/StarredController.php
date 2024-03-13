<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Starred_gifs;
use App\Models\Log;

class StarredController extends Controller
{
    public function add(Request $request){
        $params = [
            
            'gif_id' => $request["gif_id"],
            "alias" => $request["alias"],
            "user_id" => $request["user_id"],
        ];
        Log::create( [ 'service' => $request->path(), 'user' => $request["user_id"], 'request_body' => json_encode($request->all()), 'response_code' => 200, 'response_body' => '', 'source_ip' => $request->ip(), ] );
        $starred = Starred_gifs::create($params);
    }


}
