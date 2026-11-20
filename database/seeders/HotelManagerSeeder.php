<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HotelManagerSeeder extends Seeder
{
    public function run(): void
    {
        // 1. The hotel manager account (owner of the hotel)
        $manager = User::where('email', 'manager@destigo.test')->first()
            ?? User::forceCreate([
                'full_name' => 'Grand Hotel Manager',
                'email'     => 'manager@destigo.test',
                'password'  => Hash::make('password'),
                'role'      => 'hotel_manager',
            ]);

        // 2. The hotel
        $hotel = Hotel::firstOrCreate(
            ['user_id' => $manager->id],
            [
                'hotel_name'  => 'Grand Hotel',
                'city'        => 'Colombo',
                'address'     => '12 Galle Road, Colombo 03',
                'rating'      => 4.5,
                'description' => 'Sample hotel for testing the Hotel Manager module.',
            ]
        );

        // 3. Rooms: number, type, price, capacity, status
        $roomData = [
            ['101', 'Deluxe',   12500, 2, 'available'],
            ['102', 'Deluxe',   12500, 2, 'available'],
            ['103', 'Standard',  8500, 2, 'available'],
            ['104', 'Standard',  8500, 2, 'available'],
            ['201', 'Family',   15000, 4, 'booked'],
            ['202', 'Family',   15000, 4, 'available'],
            ['203', 'Family',   15000, 4, 'available'],
            ['301', 'Suite',    22000, 3, 'booked'],
            ['302', 'Suite',    22000, 3, 'available'],
            ['303', 'Suite',    22000, 3, 'available'],
        ];

        $rooms = [];
        foreach ($roomData as [$number, $type, $price, $capacity, $status]) {
            $rooms[$number] = Room::firstOrCreate(
                ['hotel_id' => $hotel->id, 'room_number' => $number],
                [
                    'room_type'       => $type,
                    'price_per_night' => $price,
                    'capacity'        => $capacity,
                    'status'          => $status,
                ]
            );
        }

        // 4. Guests and their bookings: name, email, room, status, days until check-in, nights
        $bookingData = [
            ['John Smith',   'john@example.com',   '101', 'pending',   5,  2],
            ['Sarah Meena',  'sarah@example.com',  '201', 'confirmed', 3,  3],
            ['Mike Ono',     'mike@example.com',   '301', 'confirmed', 1,  3],
            ['Nimal Perera', 'nimal@example.com',  '102', 'cancelled', 8,  2],
            ['Kamala Silva', 'kamala@example.com', '202', 'pending',   10, 4],
        ];

        foreach ($bookingData as [$name, $email, $roomNumber, $status, $startIn, $nights]) {
            $guest = User::where('email', $email)->first()
                ?? User::forceCreate([
                    'full_name' => $name,
                    'email'     => $email,
                    'password'  => Hash::make('password'),
                    'role'      => 'user',
                ]);

            // Skip if this guest already has a booking here (so re-running does not duplicate)
            if (Booking::where('user_id', $guest->id)->where('hotel_id', $hotel->id)->exists()) {
                continue;
            }

            $room     = $rooms[$roomNumber];
            $checkIn  = now()->addDays($startIn);
            $checkOut = $checkIn->copy()->addDays($nights);

            $booking = Booking::create([
                'user_id'     => $guest->id,
                'hotel_id'    => $hotel->id,
                'check_in'    => $checkIn->toDateString(),
                'check_out'   => $checkOut->toDateString(),
                'guests'      => 2,
                'total_price' => $room->price_per_night * $nights,
                'status'      => $status,
            ]);

            // Link the room to the booking through the booking_rooms table
            $booking->rooms()->attach($room->id, [
                'guests'          => 2,
                'price_per_night' => $room->price_per_night,
            ]);
        }
    }
}