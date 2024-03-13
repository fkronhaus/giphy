<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Log;




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
        $response =  Http::get($this->endpoint, $params)->body();

        $responseCode = 200;

        Log::create( [ 'service' => $request->path(), 'user' => $request["user_id"], 'request_body' => json_encode($request->all()), 'response_code' => $responseCode, 'response_body' => json_encode($response), 'source_ip' => $request->ip(), ] );
    
        return response()->json($response, $responseCode);
    }

    public function get(Request $request){
        
        $params = [
            'api_key' => $this->api_key,
            'gif_id' => $request["id"],
        ];
        
        $response = Http::get($this->details_endpoint . '/' . $request["id"] , $params)->body();

        $responseCode = 200;

        Log::create( [ 'service' => $request->path(), 'user' => $request["user_id"], 'request_body' => json_encode($request->all()), 'response_code' => $responseCode, 'response_body' => json_encode($response), 'source_ip' => $request->ip(), ] );
    
        return response()->json($response, $responseCode);
  
    }

    public function info(Request $request) {
        
        if (is_null($request->header('giphyToken'))) {
            return response()->redirectTo(route('home', ["expired" => 1]));
        }
        $response = $this->get($request);
        
        $response = json_decode($response->content(),true);
        
        return view('giphy.info', ['message' => '', 'response' => $response ] );
    
    }

    


}
