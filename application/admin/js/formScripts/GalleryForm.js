function initGalleryForm(galleryId) {
    if (typeof galleryId === "undefined") {
        galleryId = 0;
    }
    loadGallery(galleryId);
    //loadInsertContainer(galleryId);

    $('#galleryPictures').ajaxForm({
        success: function () {
            loadGallery(galleryId);
        }
    });

    $('#pictureSort').sortable({
        update: function (event, ui) {
            $('#galleryPictures').submit();
        }
    });
}

function loadGallery(galleryId) {
    $('#pictureSort').load('Gallery', { event:'getGalleryList', MainHeaderId:galleryId });
}

function cropForm(data) {
    $.post('../admin/Crop', { 
        event:'RenderCropForm',
        picId:data.picId,
        galleryId: data.galleryId, 
        fileName: data.fileName,
        thumbFileName: data.thumbFileName,
        mode:data.mode,  
        targW: data.targW,
        targH: data.targH
    }, function (data) {
        $('#lgModalContainer').html(data);	
    });
    $("#lgFormModal").modal();
}

function select_filler(select_id, min_value, max_value) {
    for (i = min_value; i <= max_value; i++) {
        $('#' + select_id).append('<option value="' + i + '">' + i + '</option>');
    }
}

function descriptionForm(data) {
    $.post('Gallery', { 
            event:'RenderDescriptionForm',
            pictureId: data.pictureId
        },
        function (data) {
            $('#modalContainer').html(data);
        }
    );

    $('#formModal').modal('show');
}

function loadPictureUploadForm(galleryId) {
    $("#modalContainer").load("../admin/Gallery", { event: 'RenderPictureUploadForm', galleryId:galleryId }, function () {
        $("#formModal").modal('show');
    });
}

function loadMusicUploadForm(galleryId) {
    $("#modalContainer").load("../admin/Gallery", { event: 'RenderMusicUploadForm', galleryId:galleryId }, function () {
        $("#formModal").modal('show');
    });
}

function loadVideoUploadForm() {
    
}

function loadYoutubeUploadForm(galleryId) {
    $("#modalContainer").load("../admin/Gallery", { event: 'RenderYoutubeUploadForm', galleryId:galleryId }, function () {
        $("#formModal").modal('show');
    });    
}