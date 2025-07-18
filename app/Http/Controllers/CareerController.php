<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::latest()->get();
        return view('careers.index', compact('careers'));
    }

    public function create()
    {
        return view('careers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'location' => 'nullable',
            'type' => 'required',
            'experience' => 'nullable',
            'valid_through' => 'nullable|date',
            'status' => 'required'
        ]);

        Career::create($data);
        return redirect()->route('careers.index')->with('success', 'Job added.');
    }

    public function edit(Career $career)
    {
        return view('careers.create', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'location' => 'nullable',
            'type' => 'required',
            'experience' => 'nullable',
            'valid_through' => 'nullable|date',
            'status' => 'required'
        ]);

        $career->update($data);
        return redirect()->route('careers.index')->with('success', 'Job updated.');
    }

//     public function showAll()
// {
//     $jobs = Career::where('status', 'active')->orderBy('valid_through', 'desc')->get();
//     return view('front.careers', compact('jobs'));
// }

    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->route('careers.index')->with('success', 'Job deleted.');
    }

   
}
