<?php
namespace WoR;

class Agent {
  private $value;

  function __construct($agt) {
    $this->value = $agt;
  }

  public static function matchesCurrent($agent) {
    // if user did not specify agent, return like it's found
    if (!isset($agent)) return true;

    $real_agent = Main::get_instance()->current_request->real_agent;

    if (is_array($agent)) {
      return \_u::any($agent, function($agt) use($real_agent) {
        return preg_match($agt, $real_agent);
      });

    } else {
      return preg_match($agent, $real_agent);
    }
  }
}

