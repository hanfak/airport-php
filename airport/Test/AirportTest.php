<?php

namespace airport\Test;

use airport\src\Airport;

class AirportTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
      parent::setUp();
      $this->airport = new Airport();
    }

    public function test1()
    {
      $this->airport->instructToLand('plane');

      $this->assertEquals(['plane'], $this->airport->viewHanger());
    }
}
