<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";


class CategoryModel extends Database
{
    public function getCategories() : array {
        return $this->select("SELECT * FROM category ORDER BY category_id", array());
    }

    public function addCategory($name){
        if (!$this->validateName($name)) return false;
        return $this->executeStatement("INSERT INTO category VALUES (null, :name)", array(":name" => $name));
    }

    public function updateCategory($id, $name){
        if (!$this->validateName($name)) return false;
        return $this->executeStatement('UPDATE category SET category_name = :name WHERE category_id = :id', array(":name" => $name, ":id" => intval($id)));
    }

    public function deleteCategory($id){
        $idArray = array(":id" => $id);
        $this->executeStatement("DELETE FROM post_category WHERE category_id = :id", $idArray);
        return $this->executeStatement("DELETE FROM category WHERE category_id = :id", $idArray);
    }

    private function validateName($name) : bool {
        if(!isset($name) || !is_string($name)){
            return false;
        }
        return ctype_alpha($name);
    }
}
