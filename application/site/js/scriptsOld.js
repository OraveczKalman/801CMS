// Lapozó 
function NewsPage(Page, Link) {
    $('#szoveges').load(Link, { event:'newsPageSwitch', page:Page }, function(data) {});
}

function PageSwitcher(Page) {
    $('.sheet').css("display", "none");
    $('#sheet' + Page).css("display", "block");
}