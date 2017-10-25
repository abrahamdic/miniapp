<?php

use Slim\Http\Request;
use Slim\Http\Response;
use src\controllers\Empleado;

// Routes

$app->get('/','\src\controllers\EmpleadoController:index');

$app->get('/empleado/listado','\src\controllers\EmpleadoController:index');

$app->get('/empleado/show/[{id}]', '\src\controllers\EmpleadoController:show');

$app->get('/empleado/search', '\src\controllers\EmpleadoController:buscador');

$app->get('/empleado/salario/{salario_min}/{salario_max}', '\src\controllers\EmpleadoController:salario');