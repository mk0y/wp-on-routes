<?php
namespace WoR;

class Path {
  private $value;
  private $dirs;
  private $is_home;
  private $params;

  function __construct($p) {
    $p == '/' ? $this->is_home = true : $this->is_home = false;
    $this->value = strtolower(trim($p, '/'));
    $this->dirs = explode('/', $this->value);
    $this->params = array();
  }

  public function equalsCurrent() {
    return $this->value ===
      Main::get_instance()->current_request->path->value;
  }

  /**
   * Matches params from defined params
   * @return boolean Matched params
   */
  public function matchParams() {
    if ($this->is_home &&
      Main::get_instance()->current_request->path->is_home) {
        return true;
      }

    $path_dirs = Main::get_instance()->current_request->path->dirs;

    return \_u::every($this->dirs, function($dir, $index) use ($path_dirs) {
      if (!isset($path_dirs[$index]) && Path::is_param($dir, true)) {
        return true;
      }

      if (!isset($path_dirs[$index])) {
        return false;
      }

      if ($dir === $path_dirs[$index]) {
        return true;
      }

      if (Path::is_param($dir)) {
        $this->add_param(trim($dir, ':?'), $path_dirs[$index]);
        return true;
      }

      return false;
    });
  }

  /**
   * Checks whether a string is in format ":str".
   * @param string
   * @return boolean
   */
  public static function is_param($param, $optional = false) {
    $optional ? preg_match('/\:\w+\?/', $param, $matches_param) :
      preg_match('/\:\w+/', $param, $matches_param);

    $is = is_array($matches_param) && count($matches_param) == 1 &&
      is_string($matches_param[0]) &&
      $matches_param[0][0] == ':' ?
        true : false;

    return $is;
  }

  public function add_param($name, $value) {
    $this->params[$name] = $value;
  }

  /**
   * Set $_GET params.
   */
  public function set_params() {
    \_u::each($this->params, function($param, $index) {
      $_GET[$index] = $param;
    });
  }

  public function __get($prop) {
    return $this->$prop;
  }

  public function __set($prop, $val) {
    $this->$prop = $val;
  }
}

