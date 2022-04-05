<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class PostModel extends Database
{
    public function getPostsByCategory($categoryId) : array {
        return $this->select("SELECT post_category.category_id, post_category.post_id, p.post_id, p.post_name, p.post_content
        FROM post_category INNER JOIN post p ON post_category.category_id = :categoryId AND post_category.post_id = p.post_id
        ORDER BY p.post_id", array(":categoryId" => $categoryId));
    }

    public function addPost($name, $content, $categoryIds){
        if (!$this->validatePost($name, $content)) return false;
        $this->executeStatement("INSERT INTO post VALUES (null, :name, :content)", array(":name" => $name, ":content" => $content));
        $postId = $this->connection->lastInsertId();
        $this->assignCategories($postId, $categoryIds);
        return true;
    }

    public function updatePost($id, $name, $content, $categoryIds){
        if (!$this->validatePost($name, $content)) return false;
        $this->executeStatement('UPDATE post p SET p.post_name = :name, p.post_content = :content WHERE post_id = :id', array(":name" => $name, ":content" => $content, ":id" => intval($id)));
        $this->changeCategories($id, $categoryIds);
        return true;

    }

    public function changeCategories($postId, $categoryIds){
        $this->deletePostCategories($postId);
        $this->assignCategories($postId, $categoryIds);
    }

    private function assignCategories($postId, $categoryIds){
        foreach ($categoryIds as $categoryId){
            $arr = array(":categoryId" => $categoryId, ":postId" => intval($postId));
            $this->executeStatement("INSERT INTO post_category VALUES (null, :categoryId, :postId)", $arr);
        }
    }

    public function deletePost($id){
        $this->deletePostCategories($id);
        return $this->executeStatement("DELETE FROM post WHERE post_id = :id", array(":id" => $id));
    }

    private function deletePostCategories($postId){
        $this->executeStatement("DELETE FROM post_category WHERE post_id = :id", array(":id" => intval($postId)));
    }

    private function validatePost($name, $content) : bool {
        if (!isset($name) || !isset($content)) return false;
        if (!is_string($name) || !is_string($content)) return false;
        if (strlen($name) > 45 || strlen($content) > 140) return false;
        return true;
    }
}
