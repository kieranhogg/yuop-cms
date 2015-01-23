<?php

class Item {
    public $title;
    public $title_text;
    public $date;
    public $body;
    public $db;
    public $category;

    public function Item() {

    }
    
    public function create($db, $title, $body, $category) {
        $this->title = $this->sanitise_title($title);
        $this->body = $body;
        $this->db = $db;
        $this->title_text = $title;
        $this->category = $category;
    }

    public function fetch($db, $title) {
        $this->title = $title;
        $this->db = $db;

        $sql = "SELECT * FROM `".TABLE_ITEMS."`, `".TABLE_CATEGORIES."` 
                WHERE title = '".$db->escape($title)."'
                AND " . TABLE_ITEMS . ".category = " .
                TABLE_CATEGORIES . ".ID
                ORDER BY date DESC
                LIMIT 1"; 
        $query = $db->query($sql);
        $item = $db->fetch_array($query);
        
        if (sizeof($item) == 1)
        {
            return false;
        }
        else {
            $this->title_text = $item['Title_text'];
            $this->date = date($item['Date']);
            $this->body = stripslashes($item['Body']);
            $this->category = $item['Category'];
            return true;
        }
    }

    public function add() {
        $add_item['Title'] = $this->title;
        $add_item['Title_text'] = $this->title_text;
        $add_item['Body'] = $this->body;
        $add_item['Date'] = date ("Y-m-d H:i:s", mktime());
        $add_item['Category'] = $this->category;
        return $this->db->query_insert(TABLE_ITEMS, $add_item);
    }

    public function delete() {
        $sql = "DELETE FROM `%s`
                WHERE Title = '%s'
                LIMIT 1";
        $sql = sprintf($sql, TABLE_ITEMS, $this->title);
        return $this->db->query($sql);
    }

    public function update($new_title) {
        $where = "title='" . $this->title . "'";
        $update['Title'] = $this->title = $this->sanitise_title($new_title);
        $update['Title_text'] = $this->title_text = $new_title;
        $update['Date'] = $this->date;
        $update['Body'] = $this->body;
        $update['Category'] = $this->category;
        return $this->db->query_update(TABLE_ITEMS, $update, $where);
    }
    
    private function sanitise_title($text)
    {
        $text = strtolower($text);
        $text = preg_replace("/[^a-zA-Z0-9-\s]/", "", $text);
        $text = str_replace(" ", "-", $text);
        return $text;
    }

}
?>
