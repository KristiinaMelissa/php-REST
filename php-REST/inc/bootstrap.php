<?php
const PROJECT_ROOT_PATH = __DIR__ . "/php-REST/";

// include main configuration file
require_once PROJECT_ROOT_PATH . "/inc/config.php";

// include the base controller file
require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";

require_once PROJECT_ROOT_PATH . "/Model/CategoryModel.php";
require_once PROJECT_ROOT_PATH . "/Model/PostModel.php";