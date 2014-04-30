<?php
namespace WoR;

class Page {
  private static $instance;
  private $route;

  public static function get_instance() {
    if (!isset(self::$instance)) {
      self::$instance = new Page();
    }

    return self::$instance;
  }

  public function set_route($r) {
    $this->route = $r;
  }

  public function __get($prop) {
    return $this->$prop;
  }

  public function __set($prop, $val) {
    $this->$prop = $val;
  }
}