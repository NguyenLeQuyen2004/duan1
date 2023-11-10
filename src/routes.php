<?php

use Lequyen\Mvc\Router;
use Lequyen\Mvc\Controllers\UserController;

$router = new Router();

$router->addRoute('/', UserController::class, 'index');
    