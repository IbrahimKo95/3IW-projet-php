<?php


require_once __DIR__ . "/core/Router.php";

require_once __DIR__ . "/controllers/LoginController.php";
require_once __DIR__ . "/controllers/RegisterController.php";
require_once __DIR__ . "/controllers/GroupController.php";
require_once __DIR__ . "/controllers/HomeController.php";
require_once __DIR__ . "/controllers/PhotoController.php";

$router = new Router();
session_start();

$router->get("", HomeController::class, "index", ["Auth"]);

$router->get("/login", LoginController::class, "index");
$router->get("/logout", LoginController::class, "logout");
$router->post("/login", LoginController::class, "post");

$router->get("/register", RegisterController::class, "index");
$router->post("/register", RegisterController::class, "post");

$router->get("/group/{id}", GroupController::class, "get", ["Auth"]);
$router->post("/group/create", GroupController::class, "store", ["Auth"]);
$router->post("/group/{id}/addUser", GroupController::class, "addUser", ["Auth"]);
$router->get("/group/{id}/manageMember", GroupController::class, "manageMember", ["Auth"]);
$router->get("/group/{id}/deleteMember/{idUser}", GroupController::class, "deleteMember", ["Auth"]);
$router->post("/group/{id}/changePermission/{idUser}", GroupController::class, "changePermission", ["Auth"]);
$router->get("/group/{id}/quitGroup", GroupController::class, "quitGroup", ["Auth"]);
$router->get("/group/{id}/parameters", GroupController::class, "parameters", ["Auth"]);
$router->post("/group/{id}/update", GroupController::class, "changeName", ["Auth"]);
$router->get("/group/{id}/delete", GroupController::class, "deleteGroup", ["Auth"]);

// $router->get("/photo", PhotoController::class, "index", ["Auth"]);
$router->get("/group/{id}/addPhotoForm", PhotoController::class, "index", ["Auth"]);
$router->post("/group/{id}/addPhoto", PhotoController::class, "addPhoto", ["Auth"]);
$router->post("/group/{id}/deletePhoto", PhotoController::class, "deletePhoto", ["Auth"]);
$router->post("/group/{id}/changeVisibility", PhotoController::class, "changeVisibility", ["Auth"]);

$router->get("/photo/{token}", PhotoController::class, "get");


// $router->get("/photo/{id}", GroupController::class, "get");
// $router->post("/group/create", GroupController::class, "store");
// $router->post("/group/{id}/addUser", GroupController::class, "addUser");

$router->start();
