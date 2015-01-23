<?php
include_once 'tbs/tbs_class.php';
include_once 'Item.class.php';
include_once 'db.inc.php';

//$title = 'Pages | ' . SITE_NAME;
$title = $_GET['title'];
$item = new Item();
$item->fetch($db, $title);
$item->category_lower = strtolower($item->category);
$page_title = $item->title_text . ' | ' . SITE_TITLE;
$TBS = new clsTinyButStrong;
$TBS->ObjectRef =& $item;
$TBS->MergeBlock('nav', $navigation_array);
$TBS->LoadTemplate('item.html');
$TBS->Show();
?>
