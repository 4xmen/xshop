<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Gallery $gallery)
    {

        $request->validate([
            'image' => ['required']
        ]);

        foreach ($request->file('image') as $k => $item) {

            DB::transaction(function () use ($gallery, $item, $request): void {

                $newimage = $gallery->images()->create([
                    'title' => $gallery->title . '-' . ($gallery->images()->count() + 1),
                    'user_id' => auth()->id(),
                ]);
                $newimage->addMedia($item)
                    ->toMediaCollection();
            });
        }
        logAdmin(__METHOD__, Gallery::class, $gallery->id);

        return redirect()->back()->with(['message' => __(':COUNT Images uploaded successfully', ['COUNT' => count($request->file('image'))] )]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
        logAdmin(__METHOD__, Image::class, $image->id);
        $image->delete();
        return redirect()->back()->with(['message' => __('Image deleted successfully')]);
    }
}
