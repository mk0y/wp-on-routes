<?php
namespace WoR;

/** Class for predefined routes like posts.json */
class Way {
  public function posts_json() {
    $query = new \WP_Query(array(
      'post_type' => 'post',
      'nopaging' => true
    ));

    $posts = [];

    if (!$query->have_posts()) return [];

    while ($query->have_posts()) {
      $query->the_post();
      global $post;

      $posts[] = (object) $post;
    }

    return $posts;
  }
}
