<?php

namespace airport\src;

class Airport
{
  public function __construct()
  {
    $this->planes = [];
  }

  public function instructToLand($plane)
  {
    $plane->land();
    array_push($this->planes, $plane);
  }

  public function viewHanger()
  {
    return $this->planes;
  }
}
