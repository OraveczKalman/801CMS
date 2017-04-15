// JavaScript Document
// Lapozó következő lap
function NextPage(Page, Num, Link) {
	//alert('/uromsc/cikk?event=news_page_switch&page=' + Page + '&limit=' + Num + '&link=' + Link);
	$('#szoveges').load('cikk?event=news_page_switch&page=' + Page + '&limit=' + Num + '&link=' + Link, function(data) {
		//alert(data);
		//$('#messagewall').html(data);
	});
}

// Lapozó előző lap
function PrevPage(Page, Num, Link) {
	$('#szoveges').load('cikk?event=news_page_switch&page=' + Page + '&limit=' + Num + '&link=' + Link, function(data) {
		//$('#messagewall').html(data);
	});
}