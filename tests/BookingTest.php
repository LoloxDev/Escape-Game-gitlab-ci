<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Booking.php';

final class BookingTest extends TestCase
{
    public function testBookingIsAvailable(): void
    {
        $booking = new Booking();
        $this->assertTrue($booking->checkAvailability('2023-12-25 15:00', 'Room 1'));
    }

    public function testBookingRegistersReservation(): void
    {
        $booking = new Booking();
        $date = '2023-12-25 16:00';
        $room = 'Room 1';
        $players = ['Alice', 'Bob'];

        $this->assertTrue($booking->book($date, $room, $players));

        $reservations = $booking->getReservations();
        $this->assertCount(1, $reservations);
        $this->assertSame($date, $reservations[0]['date']);
        $this->assertSame($room, $reservations[0]['room']);
        $this->assertSame($players, $reservations[0]['players']);

        // Le même créneau doit désormais être indisponible
        $this->assertFalse($booking->checkAvailability($date, $room));
    }

    public function testValidateAgeSuccess(): void
    {
        $booking = new Booking();
        $this->assertTrue($booking->validateAge([12, 14, 30]));
    }

    public function testValidateAgeFailsIfUnderMinimum(): void
    {
        $booking = new Booking();
        $this->assertFalse($booking->validateAge([11, 12, 15]));
    }

    public function testOutOfOpeningHoursIsUnavailable(): void
    {
        $booking = new Booking();
        $this->assertFalse($booking->checkAvailability('2023-12-25 08:00', 'Room 2'));
    }
}

