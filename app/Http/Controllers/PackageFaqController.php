<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageFaq;
use Illuminate\Http\Request;

class PackageFaqController extends Controller
{
    public function index()
    {
        $packages = Package::with(['faqs' => fn($q) => $q->orderBy('created_at','desc')])
            ->whereHas('faqs')
            ->orderBy('name')
            ->paginate(10);

        $highlight = request('highlight'); // package_id to scroll
        return view('backend.package_faqs.index', compact('packages','highlight'));
    }

    public function create()
    {
        $packages  = Package::orderBy('name')->get(['id','name']);
        $preselect = request('package_id'); // preselect in UI
        return view('backend.package_faqs.form', compact('packages','preselect'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'package_id' => 'nullable|exists:packages,id',
            'question'   => 'required|string|max:255',
            'answer'     => 'nullable|string',
            'status'     => 'required|in:active,inactive',
        ]);

        $faq = PackageFaq::create($data);

        return redirect()->route('package_faqs.index', ['highlight' => $faq->package_id])
            ->with('success', 'FAQ created.');
    }

    public function edit(PackageFaq $packageFaq)
    {
        $packages = Package::orderBy('name')->get(['id','name']);
        return view('backend.package_faqs.form', ['packages'=>$packages, 'faq'=>$packageFaq]);
    }

    public function update(Request $r, PackageFaq $packageFaq)
    {
        $data = $r->validate([
            'package_id' => 'nullable|exists:packages,id',
            'question'   => 'required|string|max:255',
            'answer'     => 'nullable|string',
            'status'     => 'required|in:active,inactive',
        ]);

        $packageFaq->update($data);

        return redirect()->route('package_faqs.index', ['highlight' => $packageFaq->package_id])
            ->with('success', 'FAQ updated.');
    }

    public function destroy(PackageFaq $packageFaq)
    {
        $pid = $packageFaq->package_id;
        $packageFaq->delete();
        return redirect()->route('package_faqs.index', ['highlight' => $pid])
            ->with('success', 'FAQ deleted.');
    }
}
