<?php

namespace airport\src;

class Airport
{
  private $weather;
  private $planes;
  private $capacity;

  const DEFAULT_CAPACITY = 10;

  public function __construct($weather,
            $capacity = self::DEFAULT_CAPACITY)
  {
    $this->planes   = [];
    $this->weather  = $weather;
    $this->capacity = $capacity;
  }

  public function instructToLand($plane)
  {
    $this->checkPlaneCanLand($plane);
    $plane->land();
    array_push($this->planes, $plane);
  }

  public function instructToTakeOff($plane)
  {
    $this->checkPlaneCanTakeOff($plane);
    if(in_array($plane, $this->planes)) {
      unset( $this->planes[ array_search( $plane, $this->planes ) ] );
      $plane->takeOff();
    }
  }

  public function viewHanger()
  {
    return $this->planes;
  }

  private function checkPlaneCanLand($plane)
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to land");
    }
    if($this->capacity <= sizeOf($this->planes)) {
      throw new \RuntimeException("Cannot land, airport is full");
    }
    if(in_array($plane, $this->planes)) {
      throw new \RuntimeException("Cannot land, plane already at aiport");
    }
  }

  private function checkPlaneCanTakeOff($plane)
  {
    if($this->weather->isStormy()) {
      throw new \RuntimeException("it is stormy to take off");
    }
    if(!in_array($plane, $this->planes)) {
      throw new \RuntimeException("Cannot take off, plane not at aiport");
    }
  }
}
