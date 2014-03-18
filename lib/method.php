<?php
namespace WoR;

class Method {
  private $value;
  public static $methods = [
    // add your own here
    'get', 'post', 'delete', 'put', 'patch'
  ];

  function __construct($method) {
    $this->value = strtolower($method);
  }

  public function equalsCurrent() {
    return $this->value === Main::get_instance()->current_request->method->value;
  }

  public static function has_method($str) {
    return in_array($str, self::$methods);
  }

  public function __get($prop) {
    return $this->$prop;
  }

  public function __set($prop, $val) {
    $this->$prop = $val;
  }
}
