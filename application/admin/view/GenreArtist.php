<?php
/**
 * Created by PhpStorm.
 * User: Kalman
 * Date: 2015.04.02.
 * Time: 18:29
 */
?>
<script type="text/javascript">
    var artists = new Bloodhound({
            datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "menu?event=getArtist&artist=%QUERY"
        }
    });

    artists.initialize();

    $('#artist').typeahead(null, {
            name: 'artist',
            displayKey: 'ArtistName',
            source: artists.ttAdapter()
        })
        .on('typeahead:selected', function($e, datum) {
        $.post('menu?event=addArtist', { artist:datum['ArtistId'], menuid: $('#menuid').val(), type:'num' }, function (data) {
            data = JSON.parse(data);
            $('#AristIdHidden').val(data.hiddenVal);
            $('#ArtistContainer').html(data.artistButtons);
        });
    });

    $('#artist').keypress(function (event) {
        if (event.which === 13) {
            $.post('menu?event=addArtist', { artist: $('#Artist').val(), menuid: $('#MenuId').val(), type:'text' }, function (data) {
                data = JSON.parse(data);
                $('#ArtistIdHidden').val(data.hiddenVal);
                $('#ArtistContainer').html(data.artistButtons);
            });
        }
    });

    var genres = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "menu?event=getGenre&genre=%QUERY"
        }
    });

    genres.initialize();

    $('#genre').typeahead(null, {
            name: 'genre',
            displayKey: 'GenreName',
            source: genres.ttAdapter()
        })
        .on('typeahead:selected', function($e, datum) {
            $.post('menu?event=addGenre', { genre:datum['GenreId'], menuid: $('#menuid').val(), type:'num' }, function (data) {
                data = JSON.parse(data);
                $('#genreIdHidden').val(data.hiddenVal);
                $('#genreContainer').html(data.genreButtons);
            });
    });

    $('#genre').keypress(function (event) {
        if (event.which === 13) {
            $.post('menu?event=addGenre', { genre: $('#genre').val(), menuid: $('#menuid').val(), type:'text' }, function (data) {
                data = JSON.parse(data);
                $('#genreIdHidden').val(data.hiddenVal);
                $('#genreContainer').html(data.genreButtons);
            });
        }
    });
</script>

<?php
if ($this->dataArray['getVars']['event'] == 'read_menu') {
?>
<div class="form-group">
    <label for="artist" class="col-sm-2 control-label"><?php print $menuJson->labels->artist; ?></label>
    <div class="col-sm-2">
        <input class="form-control" type="text" id="artist" name="artist" />
        <input type="hidden" name="artistIdHidden" id="artistIdHidden" value="<?php print $artistHiddenData; ?>" />
    </div>
    <div class="col-sm-8" id="artistContainer">
<?php
    foreach($artistData as $artistData2) {
?>
        <button type="button" class="btn btn-xs" onclick="javascript: removeArtist(<?php print $artistData2['ArtistId'] . ', ' . $menuData[0]['Menu_Id']; ?>);"><?php print $artistData2['ArtistName']; ?></button>
<?php
    }
?>
    </div>
</div>
<div class="form-group">
    <label for="genre" class="col-sm-2 control-label"><?php print $menuJson->labels->genre; ?></label>
    <div class="col-sm-2">
        <input class="form-control" type="text" id="genre" name="genre" />
        <input type="hidden" name="genreIdHidden" id="genreIdHidden" />
    </div>

    <div class="col-sm-8" id="genreContainer">
<?php
    foreach($genreData as $genreData2) {
?>
        <button type="button" class="btn btn-xs" onclick="javascript: removeGenre(<?php print $genreData2['GenreId'] . ', ' . $menuData[0]['Menu_Id']; ?>);"><?php print $genreData2['GenreName']; ?></button>
<?php
    }
?>
    </div>
</div>
<?php
}
