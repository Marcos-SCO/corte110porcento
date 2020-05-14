<?php

namespace App\Models;

class Gallery extends \Core\Model
{
    /**
     * Get all the gallery as an associative array
     * 
     * @return array
     * 
     */
    public function getAll()
    {
        $result = $this->selectQuery('gallery', "ORDER BY id DESC");
        return $result;
    }


    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM gallery WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function addImg($data)
    {
        // dump($data);
        $this->insertQuery('gallery', [
            'user_id' => $_SESSION['user_id'],
            'img_description' => $data['img_description'],
            'img' => $data['img'],
            'created_at' => date("Y-m-d H:i:s")
        ]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateImg($data)
    {
        $this->updateQuery('gallery', [
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ], ['id', $data['id']]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePost($table, $id) 
    {
        return $this->deleteQuery($table, $id);
    }
}
