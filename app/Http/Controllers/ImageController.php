<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post_image;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = Post_image::find($id);
        // remove image from public
        if(Storage::disk('public')->exists($image->img_path)) {
            Storage::disk('public')->delete($image->img_path);
        }
        
        $image->delete();

        return response('Done', 200)
        ->header('Content-Type', 'text/plain');
    }
}
