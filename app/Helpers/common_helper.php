<?php

function prd($data)
{
    echo "<pre>";
    print_r($data);
    die;
}

function pr($data)
{
    echo "<pre>";
    print_r($data);
}

function isActive($ctrl, $mthd = false)
{
    $router = service('router');
    $controller = $router->controllerName();
    $controllerName = explode('\\', $controller);
    $controllerName = strtolower(end($controllerName));
    $method = $router->methodName();
    $methodName = explode('\\', $method);
    $methodName = strtolower(end($methodName));
    if (!$mthd) {
        echo $controllerName == $ctrl ? "active" : "";
    } else {
        echo $controllerName == $ctrl && $methodName == $mthd ? "active" : "";
    }
}