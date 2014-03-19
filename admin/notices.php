<?php
function wor_phpversion() {
  echo '<div class="error fade">'
    . '<p>Your PHP version is too old for wp-on-routes plugin to work.'
    . ' At least version 5.3.0 is required.</p>'
    . '</div>';
}
