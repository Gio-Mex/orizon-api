<?php
require '../router/Router.php';
$router = new Router();
$routes = require '../router/routes.php';
$router->route();
?>