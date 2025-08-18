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
            'title'           => 'required|string|max:255',
    'type'            => 'required|in:Full Time,Part Time,Internship,Contract',
    'valid_through'   => 'nullable|date',
    'status'          => 'required|in:active,inactive',
    'is_remote'       => 'sometimes|boolean',

    // Address only if NOT remote
    'street_address'  => ['nullable','string','max:255'],
    'location'        => ['nullable','string','max:120'],
    'region'          => ['nullable','string','max:120'],
    'postal_code'     => ['nullable','string','max:20'],
    'country'         => ['nullable','string','max:3'],

    // Salary
    'salary_min'      => 'nullable|integer|min:0',
    'salary_max'      => 'nullable|integer|min:0|gte:salary_min',
    'salary_currency' => 'nullable|string|size:3',
    'salary_unit'     => 'nullable|in:HOUR,DAY,WEEK,MONTH,YEAR',
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
           'title'           => 'required|string|max:255',
    'type'            => 'required|in:Full Time,Part Time,Internship,Contract',
    'valid_through'   => 'nullable|date',
    'status'          => 'required|in:active,inactive',
    'is_remote'       => 'sometimes|boolean',

    // Address only if NOT remote
    'street_address'  => ['nullable','string','max:255'],
    'location'        => ['nullable','string','max:120'],
    'region'          => ['nullable','string','max:120'],
    'postal_code'     => ['nullable','string','max:20'],
    'country'         => ['nullable','string','max:3'],

    // Salary
    'salary_min'      => 'nullable|integer|min:0',
    'salary_max'      => 'nullable|integer|min:0|gte:salary_min',
    'salary_currency' => 'nullable|string|size:3',
    'salary_unit'     => 'nullable|in:HOUR,DAY,WEEK,MONTH,YEAR',
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
