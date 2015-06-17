<?php
namespace WoR;

class Template {
  function __construct() {
  }

  public static function delegate() {
    $route = Route::filter_by_request();
    if (!$route || empty($route)) return;

    if ($route->headers) {
      $route->headers->set_all();
    }

    if ($route->path->params) {
      $route->path->set_params_gets();
    }

    if ($route->path->splats) {
      $route->path->set_splat_gets();
    }

    header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');

    if (is_bool($route->include_template) && $route->include_template) {
      self::print_wp($route);

    } else {
      self::print_body($route);
    }

    if (!is_bool($route->include_template) || !$route->include_template) {
      exit;
    }
  }

  public static function print_wp($route) {
    if (!defined('ABSPATH')) {
      return;
    }

    Page::get_instance()->route = $route;

    add_filter('template_include', array(__CLASS__, 'wipe_template'), 1);
  }

  public static function wipe_template($template) {
    return WOR_PATH . '/lib/body.php';
  }

  public static function print_body($route) {
    isset($route->action) ?
      do_action($route->action)
      : (
        is_scalar($route->body) ?
          print($route->body)
          :
          print('Unknown output.')
      );
  }


  public static function delegate_predefined() {
    if (!isset($_SERVER['REQUEST_URI'])) return;

    $path = untrailingslashit($_SERVER['REQUEST_URI']);
    $jsonapi = new Jsonapi();
    $result = '[]';

    if (untrailingslashit(strtolower(basename($path))) == 'posts.json') {
      $result = $jsonapi->posts_json();
      self::json_response($result);
    }
  }


  private static function json_response($result) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 200 Ok');
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
  }
}

