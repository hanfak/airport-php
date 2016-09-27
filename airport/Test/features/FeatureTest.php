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

    $this->setExpectedException(\RuntimeException::class);
    $airport->instructToTakeOff();
    // Check plane has not left airport
    $this->assertContains($plane, $airport->viewHanger());
    $this->assertTrue($plane->isAtAiport());
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


    $this->setExpectedException(\RuntimeException::class);
    $airport->instructToLand($plane);
    // Check plane has not arrived at airport
    $this->assertEmpty($PlanesInAirport);
    $this->assertFalse($plane->isAtAiport());
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

    $this->setExpectedException(\RuntimeException::class);
    $airport->instructToLand($plane2);

    $this->assertContains($plane1, $airport->viewHanger());
    $this->assertFalse(in_array($plane2, $airport->viewHanger()));
    $this->assertTrue($plane1->isAtAiport());
    $this->assertFalse($plane2->isAtAiport());
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
      $airport->instructToLand($plane);
    }

    $this->setExpectedException(\RuntimeException::class);
    $airport->instructToLand($plane);
  }
}
