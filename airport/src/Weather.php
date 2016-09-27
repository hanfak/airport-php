<?php

namespace airport\src;

class Weather
{
  public function isStormy()
  {
    if(rand(1,10)>7) {
      return 'it is stormy';
    }
  }
}
