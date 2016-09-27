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
}
