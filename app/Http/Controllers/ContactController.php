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
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'nullable|email',
        'subject' => 'nullable|string|max:255',
        'message' => 'nullable|string',
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
