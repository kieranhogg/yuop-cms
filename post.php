<?php
require 'db.inc.php';
require 'Item.class.php';
require 'tbs/tbs_class.php';
require 'auth.inc.php';
$mode = 'new';
$page_title = 'New page | ' . SITE_TITLE;

if (!empty($_POST['title']) AND !empty($_POST['body'])) {
    $item = new Item();
    $item->create($db, $_POST['title'], $_POST['body'], $_POST['category']);
    if ($item->add()) {
        echo '<p class="success">Item posted successfully</p>';
    }
    else {
        echo '<p class="fail">Item posting failed</p>';
    }
    echo '<br /><a href="' . $item->title . '.html">View Item</a>';
}
else {
    $sql = sprintf("SELECT * FROM `%s`", TABLE_CATEGORIES);
    $list = $db->fetch_all_array($sql);
    
    $TBS = new clsTinyButStrong;
    $TBS->LoadTemplate('post.html');
    $TBS->MergeBlock('cat', $list);
    $TBS->Show();
}



?>
