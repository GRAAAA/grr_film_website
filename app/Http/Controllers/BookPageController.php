<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookPageController extends Controller
{
    public function index()
    {
        // Fetch booked dates
        $bookedDates = DB::table('bookings')
            ->select('booking_date')
            ->distinct()
            ->pluck('booking_date')
            ->toArray();

        // Make $bookedDates available in book.php
        include resource_path('pages/book.php');
    }

    public function submitBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        DB::table('bookings')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'booking_date' => $request->input('booking_date'),
            'booking_time' => $request->input('booking_time'),
            'notes' => $request->input('notes'),
        ]);

        return redirect('/book')->with('success', 'Booking submitted successfully!');
    }
}
