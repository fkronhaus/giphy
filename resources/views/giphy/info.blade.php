
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="{{json_decode($response,true)["data"]['images']['original']['url']}}" alt="">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="">Giphy Info: </label>
                <pre>
                    {{print_r(json_decode($response,true))}} 
                </pre>
            </div>
        </div>
    </div>
