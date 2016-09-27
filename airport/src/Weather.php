<?php

namespace airport\src;

class Weather
{
  public function isStormy()
  {
    return rand(1, 10) > 7;
  }
}
