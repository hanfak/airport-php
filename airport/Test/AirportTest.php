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
    $this->weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $this->airport->instructToLand($this->plane);

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

    // $this->setExpectedException(\RuntimeException::class);
    // $this->airport->instructToTakeOff($this->plane);

    try {
      $this->airport->instructToTakeOff($this->plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "it is stormy cannot take off");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  public function test6PlaneCannotLandWhenStormy()
  {
    $this->weather->expects($this->once())
           ->method("isStormy")
           ->will($this->returnValue(true));

    try {
      $this->airport->instructToLand($this->plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "it is stormy to land");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  public function test7PlaneCannotLandWhenAirportIsFull()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));
    for($counter = 1; $counter <11; $counter++)
    {
      $diff_plane = $this->getMock('Plane', ["land", "takeOff"]);
      $this->airport->instructToLand($diff_plane);
    }

    try {
      $this->airport->instructToLand($this->plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, airport is full");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  public function test8ChangeAirportCapacity()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));
    $this->plane1 = $this->getMock('Plane', ["land", "takeOff"]);
    $this->airport1 = new Airport($this->weather,5);

    for($counter = 1; $counter <6; $counter++)
    {
      $diff_plane = $this->getMock('Plane', ["land", "takeOff"]);
      $this->airport1->instructToLand($diff_plane);
    }

    try {
      $this->airport1->instructToLand($this->plane1);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, airport is full");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  public function test9CannotLandPlaneIfAtAirport()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));
    $this->airport->instructToLand($this->plane);

    try {
      $this->airport->instructToLand($this->plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, plane already at aiport");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  public function test10CannotTakeOffIfNotAtAirport()
  {
    $this->weather->expects($this->any())
           ->method("isStormy")
           ->will($this->returnValue(false));

    try {
      $this->airport->instructToTakeOff($this->plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot take off, plane not at aiport");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }
}
