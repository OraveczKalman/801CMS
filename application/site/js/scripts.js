// Lapozó 
function NewsPage(Page, Link) {
    $('#szoveges').load(Link, { event:'newsPageSwitch', page:Page }, function(data) {});
}