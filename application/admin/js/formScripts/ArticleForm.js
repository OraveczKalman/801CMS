function addNewChapter(mainHeaderId) {
    $('#lgModalContainer').load('Article', { event:'RenderNewArticleForm', MainHeaderId:mainHeaderId });
    $('#lgFormModal').modal('show');
}

function modifyChapter(mainHeaderId, chapterId) {
    $('#lgModalContainer').load('Article', { event:'RenderEditArticleForm', MainHeaderId:mainHeaderId, chapterId:chapterId });
    $('#lgFormModal').modal('show');   
}

function deleteChapter(chapterId) {
    
}

/*function loadInsertContainer(galleryId) {
    $.post('../admin/Gallery', {event:'GetInsertList', MainHeaderId:galleryId}, function(data) {
        $('#galleryInsertContainer').html(data);
    });
}*/

/*var cikkNum = 0;
var actChapter = 'article0';
var actStateHidden = 'chapterState0';
var chaptersArray = new Array();

$(document).ready(function() {
    $('#articleForm').submit(function () {
        $(this).ajaxSubmit({
            datatype:'json',
            beforeSubmit: CKupdate(),
            success: processError
        });
        return false;
    });
    addNewEditor('article0', 0);
});

function processError(data) {
    data = JSON.parse(data);
    if (typeof data.good !== "undefined") {
        $('#MessageBox #MessageBody').html('<div style="text-align: center;">A mentés sikeres volt!</div>');
        $('#MessageBox').modal('show');
        setTimeout(function () {      
            $('#ArticleContainer').load('admin/Article', { event:'editArticleForm', MainHeaderId:data.good });
            loadInsertContainer(data.good);
            $('#MessageBox').modal('hide');
        }, 5000);
    } else if (typeof data.error !== "undefined") {
        showErrors(data.error);
    }
}

function CKupdate() {
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
}

function insertAtCursor(insert) {
    console.log(actChapter);
    if (actChapter !== "article0") {
        insert = insert.trim();
        CKEDITOR.instances[actChapter].insertText(insert);
        if (parseInt($('#' + actStateHidden).val(), 10) === 0) {
            $('#' + actStateHidden).val(2);
        }
    }
}
    
function selectChapter(name, stateName) {
    actChapter = name;
    actStateHidden = stateName;
    if (parseInt($('#' + actStateHidden).val(), 10) === 0) {
        $('#' + actStateHidden).val(2);
    }        
    CKEDITOR.instances[actChapter].focus();
}    

function addNewEditor(where, num) {
    CKEDITOR.replace(where);
    CKEDITOR.instances[where].on('key', function () {
        if (parseInt($('#chapterState' + num).val(), 10) === 0) {
            $('#chapterState' + num).val(2);
        }
    });
    if (parseInt($('#currentArticleCount').val(),10) > 0) {
        $('#moreHidden').val(1);
    }
}

function addNewChapter(where, counterHidden,mainHeaderId) {
    var counter = $('.articleItem').length;
    $.post('./admin/Article', { event:'newArticleItemHead', counter:counter }, function (data) { $('#chapterNav').append(data); } );
    $.post('./admin/Article', { event:'newArticleItem', counter:counter, MainHeaderId:mainHeaderId }, function (data) { $('#chaptersDiv').append(data); } );
    $('#moreHidden').val(1);
}*/


