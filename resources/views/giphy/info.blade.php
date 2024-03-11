
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="{{$response["data"]['images']['original']['url']}}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="">Giphy Info: </label>
                <pre>{{print_r($response)}} </pre>
            </div>
        </div>
    </div>
