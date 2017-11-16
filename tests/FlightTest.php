<?php
 +
 +if (!class_exists('PHPUnit_Framework_TestCase')) {
 +    class_alias('PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');
 +}
 +
 +/**
 + * Verifies if the task entity accepts property values that meet the form
 + * validation rules, and rejects ones that don't.
 + */
 +class FlightTest extends PHPUnit_Framework_TestCase {
 +
 +    private $flight;
 +
 +    /**
 +     * Sets up a task to test with.
 +     */
 +    public function setUp() {
 +        $this->flight = new Flight();
 +    }
 +
 +    public function testIdValidFormat() {
 +        $id = 'Y001';
 +
 +        $this->flight->id = $id;
 +        $this->assertEquals($id, $this->flight->getId());
 +    }
 +
 +    public function testIdNotValidFormat() {
 +        $id = 'M414';
 +
 +        $this->flight->id = $id;
 +        $this->assertNotEquals($id, $this->flight->getId());
 +    }
 +
 +    public function testIdNotValidSize() {
 +        $id = 'Y000';
 +
 +        $this->flight->id = $id;
 +        $this->assertNotEquals($id, $this->flight->getId());
 +    }
 +
 +    public function testIdNotValidFormatSize() {
 +        $id = '9999';
 +
 +        $this->flight->id = $id;
 +        $this->assertNotEquals($id, $this->flight->getId());
 +    }
 +
 +
 +    public function testDepartureAirportValidAlpha() {
 +        $departure_airport = 'YVR';
 +
 +        $this->flight->departure_airport = $departure_airport;
 +        $this->assertEquals($departure_airport, $this->flight->getDepartureAirport());
 +    }
 +
 +    public function testDepartureAirportNotValidLength() {
 +        $departure_airport = 'YVRR';
 +
 +        $this->flight->departure_airport = $departure_airport;
 +        $this->assertNotEquals($departure_airport, $this->flight->getDepartureAirport());
 +    }
 +
 +
 +    public function testDepartureTimeValidFormat() {
 +        $departure_time = '09:00';
 +
 +        $this->flight->departure_time = $departure_time;
 +        $this->assertEquals($departure_time, $this->flight->getDepartureTime());
 +    }
 +
 +    public function testDepartureTimeNotValidFormat() {
 +        $departure_time = '0900';
 +
 +        $this->flight->departure_time = $departure_time;
 +        $this->assertNotEquals($departure_time, $this->flight->getDepartureTime());
 +    }
 +
 +    public function testDepartureTimeNotValidFormat2() {
 +        $departure_time = '09:60';
 +
 +        $this->flight->departure_time = $departure_time;
 +        $this->assertNotEquals($departure_time, $this->flight->getDepartureTime());
 +    }
 +
 +
 +    public function testArrivalAirportValidAlpha() {
 +        $arrival_airport = 'ICN';
 +
 +        $this->flight->arrival_airport = $arrival_airport;
 +        $this->assertEquals($arrival_airport, $this->flight->getArrivalAirport());
 +    }
 +
 +    public function testArrivalAirportNotValidLength() {
 +        $arrival_airport = 'ICNN';
 +
 +        $this->flight->arrival_airport = $arrival_airport;
 +        $this->assertNotEquals($arrival_airport, $this->flight->getArrivalAirport());
 +    }
 +
 +
 +    public function testArrivalTimeValidFormat() {
 +        $arrival_time = '09:00';
 +
 +        $this->flight->arrival_time = $arrival_time;
 +        $this->assertEquals($arrival_time, $this->flight->getArrivalTime());
 +    }
 +
 +    public function testArrivalTimeNotValidFormat() {
 +        $arrival_time = '0900';
 +
 +        $this->flight->arrival_time = $arrival_time;
 +        $this->assertNotEquals($arrival_time, $this->flight->getArrivalTime());
 +    }
 +
 +    public function testArrivalTimeNotValidFormat2() {
 +        $arrival_time = '09:60';
 +
 +        $this->flight->arrival_time = $arrival_time;
 +        $this->assertNotEquals($arrival_time, $this->flight->getArrivalTime());
 +    }
 +
 +    public function testDayOfWeekNotValidDay() {
 +        $day = 'Sunnyday';
 +
 +        $this->flight->day = $day;
 +        $this->assertNotEquals($day, $this->flight->getDayOfWeek());
 +    }
 +}