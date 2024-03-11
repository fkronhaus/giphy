<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Starred_gifs;

class StarredController extends Controller
{
    public function add(Request $request){
        $params = [
            
            'gif_id' => $request["gif_id"],
            "alias" => $request["alias"],
            "user_id" => $request["user_id"],
        ];

        $starred = Starred_gifs::create($params);
    }


}
