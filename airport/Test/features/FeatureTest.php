<?php

namespace airport\Test\features;

use airport\src\Airport;
use airport\src\Plane;
use airport\src\Weather;

class FeatureTest extends \PHPUnit_Framework_TestCase
{
  /** @test */
  public function UserStory1()
  {
    $weather = new Weather();
    $airport = new Airport($weather);
    $plane = new Plane();

    $airport->instructToLand($plane);

    $this->assertContains($plane, $airport->viewHanger());
    $this->assertTrue($plane->isAtAiport());
  }

  /** @test */
  public function UserStory2()
  {
    // $weather = new Weather();
    // Stubbing only the method, rather than mocking object???
    $plane = new Plane();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
     $airport = new Airport($weather);

    $airport->instructToLand($plane);
    $airport->instructToTakeOff($plane);

    $PlanesInAirport = $airport->viewHanger();

    $this->assertEmpty($PlanesInAirport);
    $this->assertFalse($plane->isAtAiport());
  }

  /** @test */
  public function UserStory3()
  {
    $plane = new Plane();
    // $weather = new Weather();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->at(0))
         ->method("isStormy")
         ->will($this->returnValue(false));
    $weather->expects($this->at(1))
      ->method("isStormy")
      ->will($this->returnValue(true));
    $airport = new Airport($weather);

    $airport->instructToLand($plane);

    try {
      $airport->instructToTakeOff($plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "it is stormy cannot take off");
        $this->assertContains($plane, $airport->viewHanger());
        $this->assertTrue($plane->isAtAiport());
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  /** @test */
  public function UserStory4()
  {
    $plane = new Plane();
    // $weather = new Weather();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue(true));
    $airport = new Airport($weather);

    try {
      $airport->instructToLand($plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "it is stormy to land");
        $this->assertEmpty($airport->viewHanger());
        $this->assertFalse($plane->isAtAiport());
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  /** @test */
  public function UserStory5()
  {
    $plane1 = new Plane();
    $plane2 = new Plane();
    // $weather = new Weather();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $airport = new Airport($weather,1);

    $airport->instructToLand($plane1);

    try {
      $airport->instructToLand($plane2);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, airport is full");
        $this->assertContains($plane1, $airport->viewHanger());
        $this->assertFalse(in_array($plane2, $airport->viewHanger()));
        $this->assertTrue($plane1->isAtAiport());
        $this->assertFalse($plane2->isAtAiport());
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  /** @test */
  public function UserStory6()
  {
    $plane = new Plane();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $airport = new Airport($weather,5);

    for($counter = 1; $counter <6; $counter++)
    {
      $airport->instructToLand(new Plane());
    }

    try {
      $airport->instructToLand($plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, airport is full");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  /** @test */
  public function UserStory7()
  {
    $plane = new Plane();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $airport = new Airport($weather);
    $airport->instructToLand($plane);

    try {
      $airport->instructToLand($plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot land, plane already at aiport");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }

  /** @test */
  public function UserStory8()
  {
    $plane = new Plane();
    $weather = $this->getMock('weather', ["isStormy"]);
    $weather->expects($this->any())
         ->method("isStormy")
         ->will($this->returnValue(false));
    $airport = new Airport($weather);

    try {
      $airport->instructToTakeOff($plane);
    }
    catch (\RuntimeException $ex) {
        $this->assertEquals($ex->getMessage(), "Cannot take off, plane not at aiport");
        return;
    }
    $this->fail("Expected Exception has not been raised.");
  }
}
