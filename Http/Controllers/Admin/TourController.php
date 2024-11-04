<?php

namespace Modules\IfaTours\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\IfaTours\Models\Tour;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class TourController
 */
class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return view('ifatours::admin.index', compact('tours'));
    }

    public function create(Tour $tour)
    {
        $awards = Award::all();
        return view('ifatours::admin.create', compact('tour', 'awards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teaser_img' => 'image|nullable|max:16384',
            'teaser_txt' => 'required|string|max:255',
            'description' => 'nullable|string',
            'award_id' => 'nullable|exists:awards,id',
        ]);

        $tourData = $request->all();
        $file = $request->file('teaser_img');
        if ($request->hasFile('teaser_img')) {
            $filename = 'tour_' . time() . '.' . $file->getClientOriginalExtension();

            $image = Image::make($file->getPathname());
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $imagePath = public_path('uploads/' . $filename);
            $image->save($imagePath, 80);

            $tourData['teaser_img'] = 'uploads/' . $filename;
        } else {
            Log::info('No teaser image uploaded.');
        }

        Tour::create($tourData);

        return redirect()->route('ifatours.admin.tours.index')->with('success', 'Tour created.');
    }

    public function edit(Tour $tour)
    {
        $awards = Award::all();
        $fileName = basename($tour->teaser_img);
        return view('ifatours::admin.edit', compact('tour', 'awards', 'fileName'));
    }

    public function update(Request $request, Tour $tour)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teaser_img' => 'image|nullable|max:16384',
            'teaser_txt' => 'required|string|max:255',
            'description' => 'nullable|string',
            'award_id' => 'nullable|exists:awards,id',
        ]);

        $tourData = $request->all();

        if ($request->hasFile('teaser_img')) {
            if ($tour->teaser_img) {
                $oldImagePath = public_path($tour->teaser_img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $file = $request->file('teaser_img');
            if ($file->isValid()) {
                $filename = 'tour_' . time() . '.' . $file->getClientOriginalExtension();

                $image = Image::make($file->getPathname());
                $image->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $imagePath = public_path('uploads/' . $filename);
                $image->save($imagePath, 80);

                $tourData['teaser_img'] = 'uploads/' . $filename;
            } else {
                Log::error('File upload failed: ' . $file->getError());
            }
        }

        $tour->update($tourData);

        return redirect()->route('ifatours.admin.tours.edit', $tour->id)->with('success', 'Tour updated.');

    }

    public function destroy(Tour $tour)
    {
        $tour->delete();

        return redirect()->route('ifatours.admin.tours.index')->with('success', 'Tour deleted.');
    }
}
