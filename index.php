<?php
require __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

if ((isset($uri[2]) && $uri[2] != 'category' && $uri[2] != 'post') || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
if (isset($uri[2])){
    if ($uri[2] == 'category'){
        require PROJECT_ROOT_PATH . "/Controller/Api/CategoryController.php";
        $objFeedController = new CategoryController();
    }else if ($uri[2] == 'post'){
        require PROJECT_ROOT_PATH . "/Controller/Api/PostController.php";
        $objFeedController = new PostController();
    }
}


$strMethodName = $uri[3] . 'Action';
$objFeedController->{$strMethodName}();
