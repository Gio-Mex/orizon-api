<?php 
// Routes config
$router->addRoute('GET', '/countries', '../countries/controllers/read.php');
$router->addRoute('POST', '/countries', '../countries/controllers/create.php');
$router->addRoute('PUT', '/countries', '../countries/controllers/update.php');
$router->addRoute('DELETE', '/countries', '../countries/controllers/delete.php');

$router->addRoute('GET', '/travels', '../travels/controllers/read.php');
$router->addRoute('POST', '/travels', '../travels/controllers/create.php');
$router->addRoute('PUT', '/travels', '../travels/controllers/update.php');
$router->addRoute('DELETE', '/travels', '../travels/controllers/delete.php');
?>