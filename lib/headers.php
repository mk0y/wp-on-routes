<?php
namespace WoR;

class Headers {
  private $names;

  function __construct() {
  }

  public static function set_for_route($ary) {
    $headers = new Headers();
    $exclude = array();

    if (isset($ary['exclude']) || isset($ary['Exclude'])) {
      $exclude = $ary['exclude'];
      unset($ary['exclude']);
    }

    $headers->names = \_u::invoke($ary, 'trim');
    if (!empty($exclude)) $headers->names['exclude'] = $exclude;
    return $headers;
  }

  public function set_all() {
    foreach ($this->names as $header => $value) {
      if (strtolower($header) == 'exclude') {
        \_u::each($value, function($v, $i) {
          header_remove($v);
        });

      } else
        header($header . ': ' . $value);
    }
  }
}

