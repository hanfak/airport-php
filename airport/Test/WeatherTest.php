<?php

namespace airport\Test;

use airport\src\Weather;

class WeatherTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    parent::setUp();
    $this->weather = new Weather();
  }

  public function test1ItIsStormy()
  {
    srand(1);
    $this->assertEquals('it is stormy',$this->weather->isStormy());
  }

  public function test2ItIsNotStormy()
  {
    srand(0);
    $this->assertEquals(null, $this->weather->isStormy());
  }
}
