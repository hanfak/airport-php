<?php

namespace airport\src;

class Airport
{
  private $weather;
  private $planes;
  private $capacity;

  const DEFAULT_CAPACITY = 10;

  public function __construct($weather, $capacity = self::DEFAULT_CAPACITY)
  {
    $this->planes = [];
    $this->weather = $weather;
    $this->capacity = $capacity;
  }

  public function instructToLand($plane)
  {
    $this->checkPlaneCanLand();
    $plane->land();
    array_push($this->planes, $plane);
  }

  public function instructToTakeOff()
  {
    $this->checkPlaneCanTakeOff();
    $plane = array_pop($this->planes);
    $plane->takeOff();
  }

  public function viewHanger()
  {
    return $this->planes;
  }

  private function checkPlaneCanLand()
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to land");
    }
    if($this->capacity <= sizeOf($this->planes)) {
      throw new \RuntimeException("Cannot land, airport is full");
    }
  }

  private function checkPlaneCanTakeOff()
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to take off");
    }
  }
}
