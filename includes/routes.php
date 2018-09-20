<?php

/**
 * Routes definitions.
 *
 * @return array
 */
function gbooks_routes_definitions()
{
  return array(
    '/home' => array(
      'GET' => 'Controllers\HomeController::homepageAction',
    ),
    '/' => 'Controllers\HomeController::homepageAction',
    '/admin' => array(
      'GET' => 'Controllers\AdminController::adminpageAction',
    ),
    '/register' => array(
      'GET' => 'Controllers\UserAuthenticationController::registerPageAction',
      'POST' => 'Controllers\UserAuthenticationController::registerPost',
    ),
    '/login' => array(
      'GET' => 'Controllers\UserAuthenticationController::loginPageAction',
      'POST' => 'Controllers\UserAuthenticationController::loginPost',
    ),
    '/logout' => array(
      'GET' => 'Controllers\UserAuthenticationController::logoutPageAction',
    ),
    '/admin/settings' => array(
      'GET' => 'Controllers\AdminController::adminConfigPageAction',
      'POST' => 'Controllers\AdminController::adminConfigPostAction',
    ),
  );
}

/**
 * Route handler callback.
 */
function gbooks_routes_execute_handler()
{

  $routes = gbooks_routes_definitions();
  $request_method = strtoupper($_SERVER['REQUEST_METHOD']);

  $controllerClass = FALSE;
  $controllerAction = 'get';

  if (isset($routes[$_GET['q']])) {
    $routeDefinition = $routes[$_GET['q']];
    if (is_array($routeDefinition) && isset($routeDefinition[$request_method])) {
      $routeParts = explode('::', $routeDefinition[$request_method]);

    } else {
      $routeParts = explode('::', $routeDefinition);
    }

    if (!empty($routeParts)) {
      $controllerClass = $routeParts[0];
      if (isset($routeParts[1])) {
        $controllerAction = $routeParts[1];
      }
    }
  }

  if ($controllerClass) {
    $controller = new $controllerClass();
    $controller->{$controllerAction}();
  } else {
    echo '404 not found';
  }

}