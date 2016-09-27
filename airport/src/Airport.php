<?php

namespace airport\src;

class Airport
{
  private $weather;
  private $planes;

  public function __construct($weather)
  {
    $this->planes = [];
    $this->weather = $weather;
  }

  public function instructToLand($plane)
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to land");
    }
    $plane->land();
    array_push($this->planes, $plane);
  }

  public function instructToTakeOff($plane)
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to take off");
    }
    $plane->takeOff();
    array_pop($this->planes);
  }

  public function viewHanger()
  {
    return $this->planes;
  }
}
