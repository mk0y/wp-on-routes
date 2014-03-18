<?php
function wor_boot($class) {
  if (substr($class, 0, 4) == 'WoR\\') {
    $filename = WOR_PATH . '/lib/' . 
      strtolower(str_replace('\\', '/', substr($class, 4))) . '.php';

    if (file_exists($filename)) {
      require($filename);
    }
  }
}

function wor_init() {
  spl_autoload_register('wor_boot');
  add_action('init', array('\WoR\Main', 'init'), 100, 0);
}

