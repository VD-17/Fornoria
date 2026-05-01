<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index() {
        return view('customer.contact');
    }

    public function send(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required',
        ]);

        Contact::create([
            'user_id' => Auth::id(),
            'form_name' => $validated['name'],
            'form_email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return redirect()->route('contact.index')->with('success', 'Message Sent Successfully');
    }

    public function admin_form_index() {
        $forms = Contact::all();

        return view('admin.forms', compact('forms'));
    }
}
