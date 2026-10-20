<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageMediaController extends Controller
{

   public function index()
    {
        $packages = Package::with(['media' => fn($q) => $q->orderBy('created_at','desc')])
            ->whereHas('media')
            ->orderBy('name')
            ->paginate(10);

        $highlight = request('highlight'); // optional package_id to scroll to
        return view('backend.package_media.index', compact('packages','highlight'));
    }

// public function index()
//     {
//         $media = PackageMedia::with('package')->latest()->paginate(20);
//         return view('backend.package_media.index', compact('media'));
//     }

    public function create()
    {
        $packages = Package::orderBy('name')->get(['id','name']);
        return view('backend.package_media.form', compact('packages'));
    }

   public function store(Request $r)
    {
        $data = $r->validate([
            'package_id' => 'nullable|exists:packages,id',
            'status'     => 'required|in:active,inactive',
            'alt'        => 'nullable|string|max:255',
            'files'      => 'required|array|min:1',
            'files.*'    => 'file|max:51200', // 50MB
        ]);

        $created = 0;
        foreach ($r->file('files') as $file) {
            $mime = $file->getMimeType();
            if (str_starts_with($mime, 'image/')) { $type='image'; $dir='package_media/images'; }
            elseif (str_starts_with($mime, 'video/')) { $type='video'; $dir='package_media/videos'; }
            elseif ($mime === 'application/pdf') { $type='pdf'; $dir='package_media/pdfs'; }
            else { continue; }

            $path = $file->store($dir, 'public');

            PackageMedia::create([
                'package_id' => $data['package_id'] ?? null,
                'media_type' => ['type'=>$type, 'path'=>$path, 'alt'=>$data['alt'] ?? null],
                'status'     => $data['status'],
            ]);
            $created++;
        }

        return redirect()->route('package_media.index', ['highlight' => $data['package_id'] ?? null])
            ->with('success', $created ? "Uploaded {$created} file(s)." : 'No supported files found.');
    }


    public function edit(PackageMedia $packageMedium) // route-model binding: packageMedium
    {
        $packages = Package::orderBy('name')->get(['id','name']);
        return view('backend.package_media.form', [
            'packages' => $packages,
            'media'    => $packageMedium,
        ]);
    }

    public function update(Request $r, PackageMedia $packageMedium)
    {
        $data = $r->validate([
            'package_id' => 'nullable|exists:packages,id',
            'status'     => 'required|in:active,inactive',
            'alt'        => 'nullable|string|max:255',
            'file'       => 'nullable|file|max:51200',
        ]);

        // update JSON safely
        $mt = $packageMedium->media_type ?? [];
        $mt['alt'] = $data['alt'] ?? null;

        if ($r->hasFile('file')) {
            if (!empty($mt['path'])) Storage::disk('public')->delete($mt['path']);

            $mime = $r->file('file')->getMimeType();
            if (str_starts_with($mime, 'image/')) { $type='image'; $dir='package_media/images'; }
            elseif (str_starts_with($mime, 'video/')) { $type='video'; $dir='package_media/videos'; }
            elseif ($mime === 'application/pdf') { $type='pdf'; $dir='package_media/pdfs'; }
            else { return back()->withErrors(['file'=>'Unsupported file type']); }

            $mt['type'] = $type;
            $mt['path'] = $r->file('file')->store($dir, 'public');
        }

        $packageMedium->update([
            'package_id' => $data['package_id'] ?? null,
            'media_type' => $mt,
            'status'     => $data['status'],
        ]);

        return redirect()->route('package_media.index', ['highlight'=>$packageMedium->package_id])
            ->with('success', 'Media updated.');
    }

    public function destroy(PackageMedia $packageMedium)
    {
        $mt = $packageMedium->media_type ?? [];
        if (!empty($mt['path'])) Storage::disk('public')->delete($mt['path']);
        $packageMedium->delete();
        return back()->with('success', 'Media deleted.');
    }

}
