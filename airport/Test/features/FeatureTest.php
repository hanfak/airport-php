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
    $weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue(null));
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
    $weather->expects($this->once())
         ->method("isStormy")
         ->will($this->returnValue('it is stormy'));
    $airport = new Airport($weather);

    $airport->instructToLand($plane);

    $this->setExpectedException(\RuntimeException::class);
    $airport->instructToTakeOff($plane);
    // Check plane has not left airport
    $this->assertContains($plane, $airport->viewHanger());
    $this->assertTrue($plane->isAtAiport());
  }
}
