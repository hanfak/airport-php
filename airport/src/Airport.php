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
    array_push($this->planes, $plane);
    $plane->land();
  }

  public function viewHanger()
  {
    return $this->planes;
  }
}
