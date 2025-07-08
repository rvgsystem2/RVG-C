<?php

namespace App\Http\Controllers;

use App\Mail\Contact as MailContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('contact.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'name'    => 'required|string|max:255',
        //     'email'   => 'nullable|email',
        //     'phone'  => 'nullable|number|max:20',
        //     'subject' => 'nullable|string|max:255',
        //     'message' => 'nullable|string',
        // ]);
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
            ],

            'email' => [
                'nullable',
                'string',
                'max:255',
                'email:rfc,dns',
            ],

            'phone' => [
                'required_without:email',
                'nullable',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]{10,20}$/',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D/', '', $value);
                    if (strlen($digits) < 10 || strlen($digits) > 15) {
                        $fail('Phone number must have 10 to 15 digits.');
                    }
                },
            ],



            'subject' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[^<>]+$/',
            ],

            'message' => [
                'nullable',
                'string',
                'max:3000',
                'not_regex:/\b(?:https?:\/\/|www\.)\S+/i',
                'regex:/^[^<>]*$/',
            ],
        ]);
        [
            'phone.regex' => 'Please enter a valid phone number with 10-15 digits.',
        ];



        $contact = Contact::create($validated);

        // Send email (optional if email is provided)

        Mail::to('realvictorygroups@gmail.com')->send(new MailContact($contact));

        return response()->json(['success' => true]);
    }



    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contact.index')->with('success', 'Contact deleted successfully.');
    }
}
