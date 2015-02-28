<?php

class BodyTest extends WP_UnitTestCase {

  function testBodies() {
    $body = wp_remote_retrieve_body(wp_remote_get('http://wor.dev/foo/bar'));
    $this->assertEquals('Hello Baz!', $body);

    // METHOD: POST
    $body = wp_remote_retrieve_body(wp_remote_post('http://wor.dev/foo/bar'));
    $this->assertEquals('Hello Baz!', $body);

    // $_GET['param'] = 'keyboard'
    $body = wp_remote_retrieve_body(wp_remote_get('http://wor.dev/foo/bar/keyboard'));
    $this->assertEquals('Param: keyboard', $body);

    // $_GET['param1'] = 'keyboard', $_GET['param2'] = 'mouse'
    $body = wp_remote_retrieve_body(wp_remote_get('http://wor.dev/foo/bar/keyboard/mouse'));
    $this->assertEquals('Params: keyboard, mouse', $body);
  }
}

