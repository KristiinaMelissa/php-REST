<?php

class PostController extends BaseController
{
    public function listAction()
    {
        $this->list(((Closure::fromCallable([new PostController(), 'listPosts']))));
    }

    public function listPosts(): bool|string {
        $postModel = new PostModel();
        $arrQueryStringParams = $this->getQueryStringParams();

        if (isset($arrQueryStringParams['category']) && $arrQueryStringParams['category']){
            $categoryId = $arrQueryStringParams['category'];
            return json_encode($postModel->getPostsByCategory($categoryId));
        }
        return json_encode(array());
    }

    public function addAction(){
        $this->addOrUpdate((Closure::fromCallable([new PostController(), 'addPost'])));
    }

    public function addPost(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $postModel = new PostModel();
        $data = $this->getDataObject();
        $name = $data->name;
        $content = $data->content;
        $categoryIds = $data->categoryIds;
        $res = $postModel->addPost($name, $content, $categoryIds);
        if (!$res) {
            $strErrorDesc = "Post name must be up to 45 characters and content up to 140 characters!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }

    public function updateAction(){
        $this->addOrUpdate((Closure::fromCallable([new PostController(), 'updatePost'])));
    }

    public function updatePost(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $postModel = new PostModel();
        $data = $this->getDataObject();
        $id = $data->id;
        $name = $data->name;
        $content = $data->content;
        $categoryIds = $data->categoryIds;
        $res = $postModel->updatePost($id, $name, $content, $categoryIds);
        if (!$res) {
            $strErrorDesc = "Post name must be up to 45 characters and content up to 140 characters!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }

    public function deleteAction(){
        $this->delete((Closure::fromCallable([new PostController(), 'deletePost'])));
    }

    public function deletePost(): array {
        $strErrorDesc = '';
        $strErrorHeader = '';
        $postModel = new PostModel();
        $data = $this->getDataObject();
        $id = $data->id;
        $res = $postModel->deletePost($id);
        if (!$res) {
            $strErrorDesc = "Unable to delete post!";
            $strErrorHeader = 'HTTP/1.1 400 Bad Request';
        }
        return [$strErrorDesc, $strErrorHeader];
    }
}
