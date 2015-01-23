<?php

require 'db.inc.php';
require 'Item.class.php';
require 'tbs/tbs_class.php';
require 'auth.inc.php';
//die(print_r($_POST));
if (!empty($_POST['title']) AND !empty($_POST['submit'])) {
    $item = new Item();
    $item->fetch($db, $_POST['title']);
    if ($item->delete()) {
        echo '<p class="success">Item deleted successfully</p>';
    }
    else {
        echo '<p class="fail">Item delete failed</p>';
    }
}
else {
    if (!empty($_GET['title'])) {
        $title = $_GET['title'];        
        $edit_item = new Item();
        if ($edit_item->fetch($db, $title))
        {
            $page_title = 'Delete ' . $edit_item->title_text . '? | ' . SITE_TITLE;
            $TBS = new clsTinyButStrong;
            $TBS->ObjectRef =& $edit_item;
            $TBS->LoadTemplate('delete.html');
            $TBS->Show();
        }
        else {
            $error_text = 'Invalid Item';
            $TBS = new clsTinyButStrong;
            $TBS->LoadTemplate('error.html');
            $TBS->Show();
        }
    }
    else {
        $error_text = 'No title specified';
        $TBS = new clsTinyButStrong;
        $TBS->LoadTemplate('error.html');
        $TBS->Show();
    }
}



?>
