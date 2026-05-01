<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function myres_index() {
        $reservations = Reservation::where('user_id', auth()->id())->get();

        return view('customer.myreservation', compact('reservations'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => ['string', 'regex:/^(\+27|27|0)[6-8][0-9]{8}$/'],
            'num_people' => 'required|integer|min:1',
            'date' => 'required|date',
            'time' => ['required', 'regex:/^(1[0-2]|[1-9]):00 (am|pm)$/'],
            'note' => 'nullable|string',
        ],
        [
            'phone.regex' => 'Enter a valid SA number e.g. 0721234567, 27721234567, or +27721234567.',
        ]);

        Reservation::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'num_people' => $validated['num_people'],
            'date' => $validated['date'],
            'time' => \Carbon\Carbon::createFromFormat('g:i a', $validated['time'])->format('H:i:s'),
            'note' => $request->input('note'),
        ]);

        return redirect()->route('myres.index')->with('success', 'Reservation booked!');
    }

    public function cancel_res(Reservation $res) {
        $res->delete();

        return redirect()->back()->with('success', 'Reservation Cancelled');
    }

    public function admin_res_index() {
        $reservations = Reservation::all();

        return view('admin.reservations', compact('reservations'));
    }

    public function updateResStatus(Request $request, $id) {
        $res = Reservation::findOrFail($id);

        $request->validate([
            'status' => ['required', 'in:Pending,Confirmed,Cancelled'],
        ]);

        $res->status = $request->status;

        $res->save();

        return redirect()->back()->with('success', 'Reservation status updated.');
    }
}
