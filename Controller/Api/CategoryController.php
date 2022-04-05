<?php
class CategoryController extends BaseController
{
    public function listAction()
    {
        $this->list((Closure::fromCallable([new CategoryController(), 'listCategories'])));
    }

    public function listCategories(): bool|string {
        $categoryModel = new CategoryModel();

        $arrCategories = $categoryModel->getCategories();
        return json_encode($arrCategories);
    }

    public function addAction(){
        $this->addOrUpdate((Closure::fromCallable([new CategoryController(), 'addCategory'])));
    }

    public function addCategory(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $categoryModel = new CategoryModel();
        $data = $this->getDataObject();
        $name = $data->name;
        $res = $categoryModel->addCategory($name);
        if (!$res) {
            $strErrorDesc = "Category name must be up to 15 characters, alphabetical and not contain spaces!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }

    public function updateAction(){
        $this->addOrUpdate((Closure::fromCallable([new CategoryController(), 'updateCategory'])));
    }

    public function updateCategory(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $categoryModel = new CategoryModel();
        $data = $this->getDataObject();
        $id = $data->id;
        $name = $data->name;
        $res = $categoryModel->updateCategory($id, $name);
        if (!$res) {
            $strErrorDesc = "Category name must be up to 15 characters, alphabetical and not contain spaces!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }

    public function deleteAction(){
        $this->delete((Closure::fromCallable([new CategoryController(), 'deleteCategory'])));
    }

    public function deleteCategory(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $categoryModel = new CategoryModel();
        $data = $this->getDataObject();
        $id = $data->id;
        $res = $categoryModel->deleteCategory($id);
        if (!$res) {
            $strErrorDesc = "Unable to delete category!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }
}