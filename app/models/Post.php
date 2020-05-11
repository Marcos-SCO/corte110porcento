<?php

namespace App\Models;

class Post extends \Core\Model
{
    /**
     * Get all the posts as an associative array
     * 
     * @return array
     * 
     */
    public static function getAll()
    {
        $result = $this->selectQuery('posts');
        return $result;
    }

    public function getUser($id)
    {
        $result = $this->customQuery(
            "SELECT * FROM users WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function getPost($id)
    {
        $result = $this->customQuery(
            "SELECT * FROM posts WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }
    
    public function getImg($id)
    {
        $result = $this->customQuery(
            "SELECT img FROM posts WHERE `id` = :id",
            ['id' => $id]
        );
        return $result;
    }

    public function addPost($data)
    {
        // dump($data);
        $this->insertQuery('posts', [
            'user_id' => $_SESSION['user_id'],
            'title' => $data['title'],
            'body' => $data['body'],
            'img' => $data['img']
        ]);

        // Execute
        if ($this->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePost($data)
    {
        $this->updateQuery('posts', [
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

    public function getPostData()
    {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $body = isset($_POST['body']) ? trim($_POST['body']) : '';
        $img = isset($_FILES['img']) ? $_FILES['img'] : null;
        $userId = isset($_SESSION['user_id']) ? trim($_SESSION['user_id']) : '';
        $titleError = isset($_POST['title_error']) ? trim($_POST['title_error']) : '';
        $bodyError = isset($_POST['body_error']) ? trim($_POST['body_error']) : '';
        $imgPathError = isset($_POST['img_error']) ? trim($_POST['img_error']) : '';

        // Add data to array
        $data = [
            'id' => $id,
            'title' => $title,
            'body' => $body,
            'img' => $img['name'],
            'user_id' => $userId,
        ];

        $error = [
            'title_error' => $titleError,
            'body_error' => $bodyError,
            'img_error' => $imgPathError,
            'error' => false
        ];

        if (empty($data['title'])) {
            $error['title_error'] = "Coloque o título.";
            $error['error'] = true;
        }
        if (empty($data['body'])) {
            $error['body_error'] = "Preencha o campo de texto.";
            $error['error'] = true;
        }
        if (empty($data['img'])) {
            $error['img_error'] = "Insira uma imagem";
            $error['error'] = true;
        }

        return [$data, $error];
    }
}
