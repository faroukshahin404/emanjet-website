<?php
namespace App\ViewModels;

use App\Models\ReservationBookingRequest;
use App\Traits\BookingTrait;

class TicketViewModel
{
    use BookingTrait;

    public function __construct(public ReservationBookingRequest $reservation) {}

    public function toArray(): array
    {
        $seats = [];
        foreach ($this->reservation->bookingSeats as $bookingSeat) {
            $seats[] = $bookingSeat->tripSeat->seat->name;
        }
        $tripTime = $this->getTripTime($this->reservation->runTrip_id, $this->reservation->stationFrom_id);
        $user = $this->reservation->user;
        return [
            'runTrip_id'=> $this->reservation->runTrip_id,
            'ticket_id'=> $this->reservation->id,
            'city_from'=> $this->reservation->stationFrom->city->name,
            'city_to'=> $this->reservation->stationTo->city->name,
            'station_from'=> $this->reservation->stationFrom->name,
            'station_to'=> $this->reservation->stationTo->name,
            'reserv_type'=> $this->reservation->reserv_type,
            'date'=> $tripTime->format('Y-m-d'),
            'time'=> $tripTime->format('h:i a'),
            'trip_time'=> $tripTime,
            'price'=> $this->reservation->total,
            'seats'=> $seats,
            'user_name'=> $user->name,
            'user_phone'=> $user->mobile,
            'is_past'=> $tripTime->isPast(),


        ];
    }
}