<?php
namespace WoR;

class Route {
  private $method;
  private $path;
  private $headers;
  private $agent;
  private $real_agent;
  private $body;
  private $include_template;


  function __construct($ary = null) {
    if (!isset($ary)) return;

    if (isset($ary['method'])) {
      $this->method = new Method($ary['method']);
    }

    if (isset($ary['agent'])) {
      $this->agent = new Agent($ary['agent']);
    }

    if (isset($ary['real_agent'])) {
      $this->real_agent  = $ary['real_agent'];
    }

    if (isset($ary['path'])) {
      $this->path = new Path($ary['path']);
    }

    if (isset($ary['action'])) {
      $this->action = $ary['action'];
    }
    
    if (isset($ary['body'])) {
      $this->body = $ary['body'];
    }

    if (isset($ary['include_template'])) {
      $this->include_template = $ary['include_template'];
    }
  }

  public static function filter_by_request() {
    $routes = Main::get_instance()->routes;

    return \_u::find($routes, function($route) {
      return $route->method->equalsCurrent() &&
        ($route->path->equalsCurrent() || $route->path->matchParams()) &&
        // static because agent is optional
        Agent::matchesCurrent($route->agent);
    });
  }


  public function __get($prop) {
    return $this->$prop;
  }

  public function __set($prop, $val) {
    $this->$prop = $val;
  }
}

