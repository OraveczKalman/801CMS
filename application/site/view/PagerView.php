<div id="pager">
<?php
//var_dump($page);
if ($page - $limit >= 0) {
?>
    <div style="float:left; margin-top:10px;"><a href="javascript:void(0);" onclick="javascript: PrevPage(<?php print $limit; ?>, <?php print $page - $limit; ?>, '<?php print $link; ?>');">&lt;&lt; &uacute;jabb h&iacute;rek</a></div>
<?php
}
if ($page + $limit <= $_SESSION['news_count']) {
?>
    <div style="float:left; margin-left:355px; margin-top:10px;"><a href="javascript:void(0);" onclick="javascript: NextPage(<?php print $limit; ?>, <?php print $page + $limit; ?>, '<?php print $link; ?>');">kor&aacute;bbi h&iacute;rek &gt;&gt;</a></div>
<?php
}
?>
</div>