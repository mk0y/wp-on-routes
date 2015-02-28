<?php
namespace WoR;

/** User defined path */
class Path {
  private $value;
  private $dirs;
  private $is_home;
  private $params;
  private $splats;
  private $dir_index;

  function __construct($p) {
    $p == '/' ? $this->is_home = true : $this->is_home = false;
    $this->value = strtolower(trim($p, '/'));
    $this->dirs = explode('/', $this->value);
    $this->params = array();
    $this->splats = array();
    $this->dir_index = 0;
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

    if (preg_match('/\**/', $this->value)) {
      $correct_splats = $this->is_correct_params_splats();
      if ($correct_splats) $this->set_splats_params();
      return $correct_splats;

    } else {
      return $this->is_correct_params();
    }
  }

  public function is_correct_params() {
    $path_dirs = Main::get_instance()->current_request->path->dirs;

    return \_u::every($this->dirs, function($dir, $index) use ($path_dirs) {
      // optional parameter?
      if (!isset($path_dirs[$index]) && Path::is_param($dir, true)) {
        return true;
      }

      // not even optional?
      if (!isset($path_dirs[$index])) {
        return false;
      }

      // equal to user defined param?
      if ($dir === $path_dirs[$index]) {
        return true;
      }

      // is required param?
      if (Path::is_param($dir)) {
        return true;
      }

      return false;
    });
  }

  public function is_correct_params_splats() {
    $this->dir_index = 0;
    $current_dirs = Main::get_instance()->current_request->path->dirs;

    return \_u::every($current_dirs, function($dir, $index) {

      // user defined
      $ud_dir = $this->get_dir();
      $next_ud_dir = $this->get_next_dir();

      if ($dir == $ud_dir || Path::is_param($ud_dir)) {
        $this->inc_index();
        if (Path::is_param($ud_dir) || Path::is_param($ud_dir, true)) {
          $this->add_param(trim($ud_dir, ':?'), $dir);
        }

        return true;

      } elseif ($ud_dir == '*' && $dir == $next_ud_dir) {
        $this->inc_index(2);
        return true;

      } elseif ($ud_dir == '*') {
        return true;
      }

      return false;
    });
  }

  public function inc_index($int = null) {
    if (!$int) {
      $this->dir_index += 1;
    } else {
      $this->dir_index += $int;
    }
  }

  public function get_next_dir() {
    if (!isset($this->dirs[$this->dir_index + 1])) return;
    return $this->dirs[$this->dir_index + 1];
  }

  public function get_dir() {
    if (isset($this->dirs[$this->dir_index])) {
      return $this->dirs[$this->dir_index];
    }
  }

  /**
   * Checks whether a string is in format ":str".
   * @param string
   * @return boolean
   */
  public static function is_param($param, $optional = false) {
    $optional ? preg_match('/\:\w+\?/', $param, $matches_param) :
      preg_match('/\:\w+/', $param, $matches_param);

    $isarray = is_array($matches_param) && count($matches_param) == 1 &&
      is_string($matches_param[0]) &&
      $matches_param[0][0] == ':' ?
        true : false;

    return $isarray;
  }

  public function add_param($name, $value) {
    $this->params[$name] = $value;
  }

  /**
   * Set splats from current request path.
   * /a/b/[:star:]/f/g/[:star:]/x/y
   */
  public function set_splats_params() {
    $current_path = Main::get_instance()->current_request->path->value;
    $splat_path = '';
    
    $ud_index = 0;
    $splat_index = 0;
    $current_path_dirs = explode('/', $current_path);
    $this->splats[0] = '';

    foreach ($current_path_dirs as $key => $cur_dir) {
      $ud_dir = $this->dirs[$ud_index];
      @$next_ud_dir = $this->dirs[$ud_index + 1];

      if ($cur_dir == $next_ud_dir && @$is_splat_region) {
        $ud_index += 2;
        $splat_index += 1;
        $this->splats[$splat_index] = '';
        $is_splat_region = false;
        continue;
      }

      if ($cur_dir == $ud_dir) {
        $ud_index += 1;
        $is_splat_region = false;

      } else
      if (Path::is_param($ud_dir) || Path::is_param($ud_dir, true)) {
        $ud_index += 1;
        $is_splat_region = false;
        $this->add_param(trim($ud_dir, ':?'), $cur_dir);

      } else
      if ($ud_dir == '*') {
        $is_splat_region = true;
        $this->splats[$splat_index] .= $cur_dir . '/';
      }
    }

    $this->splats = array_filter($this->splats);
    $this->splats = \_u::map($this->splats,
      function($el) {return trim($el, '/');}
    );
  }

  public function set_splat_gets() {
    foreach ($this->splats as $splat) {
      $_GET['splats'][] = $splat;
    }
  }

  /**
   * Set $_GET params.
   */
  public function set_params_gets() {
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

