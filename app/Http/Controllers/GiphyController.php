<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;




class GiphyController extends Controller
{
    private $api_key = "tZ2TWwvPWbRBHKohrG0O0q4yqPa2M2TC";
    private $endpoint = "api.giphy.com/v1/gifs/search";
    private $details_endpoint = "api.giphy.com/v1/gifs";


    public function find(Request $request){

        $params = [
            'api_key' => $this->api_key,
            'q' => $request["searchString"],
            "limit"=> ($request["searchLimit"]) ? $request["searchLimit"] : null,
            "offset"=> ($request["searchOffset"]) ? $request["searchOffset"] : null,
        ];
        
        $result = Http::get($this->endpoint, $params)->body();
        return $result;
    }

    public function get($id){
        
        $params = [
            'api_key' => $this->api_key,
            'gif_id' => $id,
        ];
        
        $result = Http::get($this->details_endpoint . '/' . $id , $params)->body();

        return $result;
    }

    public function info(Request $request) {
        //dd($request->cookies);
        if (is_null($request->header('giphyToken'))) {
            return response()->redirectTo(route('home', ["expired" => 1]));
        }
        $response = $this->get($request['id']);
        $response = json_decode($response,true);
        return view('giphy.info', ['response' => $response ] );
        
    }

    


}
