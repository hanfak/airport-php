<?php

namespace airport\Test\features;

use airport\src\Airport;
use airport\src\Plane;

class FeatureTest extends \PHPUnit_Framework_TestCase
{
  /** @test */
  public function UserStory1()
  {
    $airport = new Airport();
    $plane = new Plane();

    $airport->instructToLand($plane);

    $this->assertContains($plane, $airport->viewHanger());
    $this->assertTrue($plane->isAtAiport());
  }

  /** @test */
  public function UserStory2()
  {
    $airport = new Airport();
    $plane = new Plane();

    $airport->instructToLand($plane);
    $airport->instructToTakeOff($plane);

    $PlanesInAirport = $airport->viewHanger();

    $this->assertEmpty($PlanesInAirport);
    $this->assertFalse($plane->isAtAiport());
  }
}
