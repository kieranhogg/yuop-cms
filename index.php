<?php
// include 'header.inc.php';
include_once 'tbs/tbs_class.php';
include_once 'Item.class.php';
include_once 'db.inc.php';

$page_title = 'Pages | ' . SITE_TITLE;

//otherwise show all items
$TBS = new clsTinyButStrong;
$TBS->LoadTemplate('index.html');
$sql = 'SELECT * FROM `%1$s`, `%2$s`
        WHERE `%1$s`.Category = %2$s.ID
        ORDER BY Category';
$qry = sprintf($sql, TABLE_ITEMS, TABLE_CATEGORIES);
$list = $db->fetch_all_array($qry);
$TBS->MergeBlock('row', $list);
$TBS->Show();

include 'footer.inc.php';
?>
