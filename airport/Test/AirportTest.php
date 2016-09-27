<?php

namespace airport\Test;

use airport\src\Airport;

class AirportTest extends \PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    parent::setUp();
    $this->plane = $this->getMock('Plane', ["land", "takeOff"]);
    $this->weather = $this->getMock('weather', ["isStormy"]);
    $this->airport = new Airport($this->weather);
  }

  public function test1StoresPlaneInHangerOnLanding()
  {
    $this->weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $this->airport->instructToLand($this->plane);

    $this->assertEquals([$this->plane], $this->airport->viewHanger());
  }

  public function test2PlaneLandMethodIsCalled()
  {
    $this->weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $this->plane->expects($this->once())
         ->method("land");

    $this->airport->instructToLand($this->plane);
  }

  public function test3PlaneRemovesPlaneOnTakeOff()
  {
    $this->weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $this->airport->instructToLand($this->plane);
    $this->airport->instructToTakeOff($this->plane);

    $this->assertEquals(0, sizeof($this->airport->viewHanger()));
  }

  public function test4PlaneTakeOffMethodCalled()
  {
    $this->weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $this->plane->expects($this->once())
         ->method("takeOff");

    $this->airport->instructToTakeOff($this->plane);
  }

  public function test5PlaneCannotTakeOffWhenStormy()
  {
    $this->weather->expects($this->at(0))
      ->method("isStormy")
      ->will($this->returnValue(false));
    $this->weather->expects($this->at(1))
      ->method("isStormy")
      ->will($this->returnValue(true));
    $this->airport->instructToLand($this->plane);

    $this->setExpectedException(\RuntimeException::class);

    $this->airport->instructToTakeOff($this->plane);
  }

  public function test6PlaneCannotLandWhenStormy()
  {
    $this->weather->expects($this->once())
           ->method("isStormy")
           ->will($this->returnValue(true));

    $this->setExpectedException(\RuntimeException::class);

    $this->airport->instructToLand($this->plane);
  }

  public function test7PlaneCannotLandWhenAirportIsFull()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));
    for($counter = 1; $counter <11; $counter++)
    {
      $this->airport->instructToLand($this->plane);
    }

    $this->setExpectedException(\RuntimeException::class);

    $this->airport->instructToLand($this->plane);
  }

  public function test8ChangeTheCapacity()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));
    $this->airport1 = new Airport($this->weather,5);
    for($counter = 1; $counter <6; $counter++)
    {
      $this->airport1->instructToLand($this->plane);
    }

    $this->setExpectedException(\RuntimeException::class);

    $this->airport1->instructToLand($this->plane);
  }
}
