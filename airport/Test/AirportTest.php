<?php

namespace airport\Test;

use airport\src\Airport;
use airport\src\Plane;

class AirportTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
      parent::setUp();
      $this->airport = new Airport();
      $this->plane = new Plane();
    }

    public function test1()
    {
      $this->airport->instructToLand($this->plane);

      $this->assertEquals([$this->plane], $this->airport->viewHanger());
    }
}
