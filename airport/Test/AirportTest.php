<?php

namespace airport\Test;

use airport\src\Airport;

class AirportTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    parent::setUp();
    $this->airport = new Airport();
    $this->plane = $this->getMock('Plane', ["land", "takeOff"]);
  }

  public function test1StoresPlaneInHangerOnLanding()
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

  public function test3PlaneRemovesPlaneOnTakeOff()
  {
    $this->airport->instructToLand($this->plane);
    $this->airport->instructToTakeOff($this->plane);

    $this->assertEquals(0, sizeof($this->airport->viewHanger()));
  }

  public function test4PlaneTakeOffMethodCalled()
  {
    $this->plane->expects($this->once())
         ->method("takeOff");

    $this->airport->instructToTakeOff($this->plane);
  }
}
