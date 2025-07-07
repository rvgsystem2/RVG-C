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
        ],

        // Uses Symfony’s RFC validator + DNS lookup
        'email' => [
            'nullable',
            'string',
            'max:255',
            'email:rfc,dns',
        ],

        // Generic international pattern: +, spaces, (), – allowed, must
        // contain 6‑15 digits overall.  Swap for an India‑only pattern if needed:
        // 'regex:/^(?:\+?91|0)?[6-9]\d{9}$/'
  'phone' => [
    'nullable',
    'regex:/^(?=(?:\D*\d){10,12}\D*$)\+?[0-9\s\-\(\)]+$/',
],



        'subject' => [
            'nullable',
            'string',
            'max:255',
        ],

        // 3 KB max, *no* clickable URLs allowed
        'message' => [
            'nullable',
            'string',
            'max:3000',
            // Reject if the text contains http://, https:// or www.
            'not_regex:/\b(?:https?:\/\/|www\.)\S+/i',
        ],
    ]);


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
