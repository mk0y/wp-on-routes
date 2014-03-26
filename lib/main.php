<?php
namespace WoR;

class Main {
  private static $instance;
  private $current_request;
  private $routes;

  public function __construct() {
    $this->set_vars();
  }

  public static function get_instance() {
    if (!isset(self::$instance)) {
      self::$instance = new Main();
    }

    return self::$instance;
  }

  public static function init() {
    add_action('send_headers', array(__CLASS__, 'wor_headers'));
  }

  public static function wor_headers($wp_instance) {
    Template::delegate();
  }

  private function set_vars() {
    $this->current_request = new Route(array(
      'method'      => strtolower($_SERVER['REQUEST_METHOD']),
      'path'        => $_SERVER['REQUEST_URI'],
      'real_agent'  => $_SERVER['HTTP_USER_AGENT']
    ));
  }

  public function add_routes($routes) {
    $self = $this;

    \_u::each($routes, function($items, $method) {
      if (!Method::has_method(strtolower($method))) continue;

      $route = new Route($items);
      $route->method  = new Method($method);

      if (isset($items['headers']) && is_array($items['headers'])) {
        $route->headers = Headers::set_for_route($items['headers']);
      }

      $self->routes[] = $route;
    });
  }

  public function __get($prop) {
    return $this->$prop;
  }

  public function __set($prop, $val) {
    $this->$prop = $val;
  }
}

