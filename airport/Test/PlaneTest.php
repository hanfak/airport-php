<?php

namespace airport\Test;

use airport\src\Plane;

class PlaneTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    parent::setUp();
    $this->plane = new Plane();
  }

  public function test1AtStartPlaneIsNotAtAirport()
  {
    $this->assertFalse($this->plane->isAtAiport());
  }

  public function test2PlaneAtAirportAfterLanding()
  {
    $this->plane->land();

    $this->assertTrue($this->plane->isAtAiport());
  }
}
