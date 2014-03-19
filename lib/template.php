<?php
namespace WoR;

class Template {
  function __construct() {
  }

  public static function delegate() {
    $route = Route::filter_by_request();
    if (\_u::isEmpty($route)) return;

    if ($route->headers) {
      $route->headers->set_all();
    }

    if ($route->path->params) {
      $route->path->set_params();
    }

    isset($route->action) ?
      do_action($route->action)
      : (
        !isset($route->body) ?
          print($route->body)
          :
          print('Unknown output.')
      );

    exit;
  }
}

