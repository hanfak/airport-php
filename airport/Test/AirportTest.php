<?php

namespace airport\Test;

use airport\src\Airport;

class AirportTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    parent::setUp();
    $this->airport = new Airport();
    $this->plane = $this->getMock('Plane', ["land"]);
  }

  public function test1StoresPlaneInHanger()
  {
    $this->airport->instructToLand($this->plane);

    $this->assertEquals([$this->plane], $this->airport->viewHanger());
  }

  public function test2PlaneLandMethodIsCalled()
  {
    $this->plane->expects($this->once())
         ->method("land");

    $this->airport->instructToLand($this->plane);
  }
}
