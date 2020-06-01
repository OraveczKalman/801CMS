var targetWidth = 0;
var targetHeight = 0;
var originalWidth = 0;
var originalHeight = 0;

function initCropForm(ratio, origWidth, origHeight, tWidth, tHeight) {   
    targetWidth = tWidth;
    targetHeight = tHeight;
    originalWidth = origWidth;
    originalHeight = origHeight;

    $('#imgCropOver').ajaxForm({
        success: cropOver
    });
    
    $('#cropbox').Jcrop({
        aspectRatio: ratio,
        setSelect: [0,0,originalWidth,originalHeight],
        onSelect: updateCoords,
        onChange: updateCoords
    });
}

function cropOver(galleryId) {
    loadGallery(galleryId);
    $('#lgFormModal').modal('hide');
}

function updateCoords(c) {
    showPreview(c);
    $("#x").val(c.x);
    $("#y").val(c.y);
    $("#w").val(c.w);
    $("#h").val(c.h);
}

function showPreview(coords) {
    var rx = targetWidth / coords.w;
    var ry = targetHeight / coords.h;

    $("#preView img").css({
        width: Math.round(rx*originalWidth)+'px',
        height: Math.round(ry*originalHeight)+'px',
        marginLeft:'-'+  Math.round(rx*coords.x)+'px',
        marginTop: '-'+ Math.round(ry*coords.y)+'px'
    });
}