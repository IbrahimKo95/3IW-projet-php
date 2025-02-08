<?php


require_once __DIR__ . "/core/Router.php";

require_once __DIR__ . "/controllers/LoginController.php";
require_once __DIR__ . "/controllers/RegisterController.php";
require_once __DIR__ . "/controllers/GroupController.php";
require_once __DIR__ . "/controllers/HomeController.php";

$router = new Router();
session_start();

$router->get("", HomeController::class, "index", ["Auth"]);

$router->get("/login", LoginController::class, "index");
$router->get("/logout", LoginController::class, "logout");
$router->post("/login", LoginController::class, "post");

$router->get("/register", RegisterController::class, "index");

$router->get("/group", GroupController::class, "index", ["Auth"]);
$router->get("/group/{id}", GroupController::class, "get");
$router->post("/group/create", GroupController::class, "store");
$router->post("/group/{id}/addUser", GroupController::class, "addUser");

$router->start();
