<div class="container">
  <div class="row">
    <div class="col-md-6 mb-4">
        <div class="form-group">
          <label>Defina su búsqueda de GIFs:</label>
        </div>
        <div class="form-group row">
            <label for="searchString" class="col-sm-2 col-form-label">Palabras</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="searchString" placeholder="GIFs" name="searchString">
            </div>

        </div>
        <div class="form-group row">
            <label for="searchLimit" class="col-sm-2 col-form-label"> Límite</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="searchLimit" placeholder="25" name="searchLimit">
            </div>
        </div>
        <div class="form-group row">
            <label for="searchOffset" class="col-sm-2 col-form-label">Offset</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="searchOffset" placeholder="0" name="searchOffset">
            </div>
        </div>
        <button id="giphy-search" type="button" class="btn btn-primary">Buscar</button>
    </div>
  </div>
  <h6 id="resultsTitle" class="d-none">Haga click en las imagenes para ver la vista previa del Gif</h6>
  <div id="resultsAmount"></div>
  <div id="results" class="container"></div>
</div>

<script>
    $(document).ready(function() {
        $('#results').on('click', '.previewImage', function(){
            showDownsizedGif($(this));
        });

        $('#results').on('click', '.showInfoButton', function(){
            showGifInfo($(this));
        });

        $('#results').on('click', '.setFavoriteButton', function(){
            setFavoriteGif($(this));
        });
    });
    

    function showDownsizedGif(obj){
        $(obj).attr('src', '{{ asset('images/loading.gif') }}');
        $(obj).attr('src', $(obj).closest('.giphyContainer').attr('downsizedUrl'));
    }

    function setFavoriteGif(obj){

        let id = $(obj).attr('giphy-id');
        let alias = $(obj).attr('alias');
        let user_id = getCookie('user_id');

        $.ajax({
            headers: {
                    'giphyToken' : getCookie('giphyToken')
            },
            url: '{{route("starred-add")}}', 
            method: 'POST', 
            data: { 
                gif_id: id,
                alias: alias,
                user_id: user_id
            },
            success: function(response) {
                alert('Añadido correctamente');
            },
            error: function(xhr, status, error) {
                if (xhr.status == 419){
                    console.log("Session expirada");
                    window.location.href = '/?expired=1';
                }else{
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    showErrorMessage(errorMessage);
                }
            }
        });

        }

    function showGifInfo(obj){

        let id = $(obj).attr('giphy-id');
        
        $.ajax({
            headers: {
                    'giphyToken' : getCookie('giphyToken')
            },
            url: '{{route("giphy-info")}}', 
            method: 'GET', 
            data: { 
                id: id,
            },
            success: function(response) {
                var modal = $('#modal');
                modal.find('.modal-body').html(response);
                modal.modal('show');;
            },
            error: function(xhr, status, error) {
                if (xhr.status == 419){
                    console.log("Session expirada");
                    window.location.href = '/?expired=1';
                }else{
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    showErrorMessage(errorMessage);
                }
            }
        });
        
    }

    function showGiphyResults(results){

        $('#resultsTitle').removeClass('d-none');
        $('#resultsAmount').html('Resultados encontrados: '+ results.data.length);
        
        
        container = $("#results");
        
        container.html('');
        
        $.each(results['data'], function(index, gif) {  
            
            gifContainer = $("<div>")
                            .attr('giphy-id',gif.id)
                            .attr('downsizedUrl',gif['images']['downsized_medium'].url)
                            .attr('class', 'row justify-content-center mb-4 giphyContainer');
            col12 = $('<div>').attr('class','col-12');
            
            showInfoButton = $('<button>')
                            .attr('giphy-id', gif.id)
                            .attr('class', 'showInfoButton d-block')
                            .text('Mostrar info');

            setFavoriteButton = $('<button>')
                            .attr('giphy-id', gif.id)
                            .attr('alias', gif.title)
                            .attr('class', 'setFavoriteButton d-block')
                            .text('Añadir a favoritos');

            titleRow = $('<div>').attr('class','row').html(
                $('<div>').attr('class', 'col-12').html(
                    $('<label>').text(gif.title)
                )
            );

            contentRow = $('<div>').attr('class','row');

            leftCol = $("<div>").attr('class', 'col-4 preview');

            previewImage = $('<img>')
                            .attr('role','button')
                            .attr('src', gif['images']['480w_still'].url)
                            .attr('class', 'previewImage')
                            .css('max-height', '200px');
            
            downsizedImage = $('<img>')
                            .css('max-height', '200px')
                            .attr('class','downsized');

            leftCol.append(previewImage);
            leftCol.append(showInfoButton);
            leftCol.append(setFavoriteButton);

            contentRow.append(leftCol);


            col12.append(titleRow);
            col12.append(contentRow);

            gifContainer.append(col12);
            
            container.append(gifContainer);
        });
    }

    $('#giphy-search').click(function() {
            
        var searchString = $('#searchString').val();
        var searchLimit = $('#searchLimit').val();
        var searchOffset = $('#searchOffset').val();

        $('#resultsTitle').addClass('d-none');
        $('#resultsAmount').html('Buscando...');

        var imgLoading = $('<img>').attr('src', '{{ asset('images/loading.gif') }}')
        $("#results").html(imgLoading);
        $.ajax({
            headers: {
                    'giphyToken' : getCookie('giphyToken')
            },
            url: '{{route("giphy-find")}}', 
            method: 'GET', 
            data: { 
                searchString: searchString,
                searchLimit: searchLimit,
                searchOffset: searchOffset
            },
            success: function(response) {
                
                showGiphyResults(JSON.parse(response));
            },
            error: function(xhr, status, error) {
                if (xhr.status == 419){
                    console.log("Session expirada");
                    window.location.href = '/?expired=1';
                }else{
                    var errorMessage = xhr.responseJSON.message || 'Ha ocurrido un error.';
                    showErrorMessage(errorMessage);
                }
            }
        });
    });
</script>