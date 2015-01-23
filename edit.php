<?php

require 'db.inc.php';
require 'Item.class.php';
require 'tbs/tbs_class.php';
require 'auth.inc.php';
if (!empty($_POST['title']) AND !empty($_POST['body'])) {
    $item = new Item();
    $item->fetch($db, $_POST['oldtitle']);
    $item->title_text = $_POST['oldtitle'];
    $item->title = $item->title_text;
    $item->body = $_POST['body'];
    if ($item->update($_POST['title'])) {
        echo '<p class="success">Item edited successfully</p>';
    }
    else {
        echo '<p class="fail">Item edited failed</p>';
    }
    echo "<p><a href='{$item->title}.html'>View Item</a></p>";
}
else {
    if (!empty($_GET['title'])) {
        $title = $_GET['title'];        
        $edit_item = new Item();
        if ($edit_item->fetch($db, $title))
        {
            //FIXME this really sucks, better way?
            $sql = sprintf("SELECT * FROM `%s`", TABLE_CATEGORIES);
            $list = $db->fetch_all_array($sql);
            foreach ($list as $id => $array)
            {
                if ($array['ID'] == $edit_item->category)
                {
                    $array['Selected'] = " selected='selected'";
                }
                else
                {
                    $array['Selected'] = "";
                }
                $list[$id] = $array;
            }

            $submit_text = 'Update';
            $page_title = 'Editing ' . $edit_item->title_text . ' | ' . SITE_TITLE;

            $TBS = new clsTinyButStrong;
            $TBS->ObjectRef =& $edit_item;
            $TBS->LoadTemplate('edit.html');
            $TBS->MergeBlock('cat', $list);
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
