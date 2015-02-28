<?php

class BodyTest extends WP_UnitTestCase {

  function testBodies() {
    $home_url = getenv('WOR_SITE');

    if (!$home_url) {
      $this->print_wor_site_warning();
      return;
    }

    $body = wp_remote_retrieve_body(wp_remote_get("{$home_url}/foo/bar"));
    $this->assertEquals('Hello Baz!', $body);

    // METHOD: POST
    $body = wp_remote_retrieve_body(wp_remote_post("{$home_url}/foo/bar"));
    $this->assertEquals('Hello Baz!', $body);

    // $_GET['param'] = 'keyboard'
    $body = wp_remote_retrieve_body(wp_remote_get("{$home_url}/foo/bar/keyboard"));
    $this->assertEquals('Param: keyboard', $body);

    // $_GET['param1'] = 'keyboard', $_GET['param2'] = 'mouse'
    $body = wp_remote_retrieve_body(wp_remote_get("{$home_url}/foo/bar/keyboard/mouse"));
    $this->assertEquals('Params: keyboard, mouse', $body);
  }


  function print_wor_site_warning() {
    print(PHP_EOL . '**' . PHP_EOL . 'You should export WOR_SITE variable first.'
      . PHP_EOL . '**' . PHP_EOL);
  }
}

