<?php

namespace airport\src;

class Plane
{
  public function __construct()
  {
    $this->atAirport = false;
  }

  public function land()
  {
    $this->atAirport = true;
  }

  public function takeOff()
  {
    $this->atAirport = false;
  }

  public function isAtAiport()
  {
    return $this->atAirport;
  }
}
