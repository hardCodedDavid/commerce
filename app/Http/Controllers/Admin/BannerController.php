<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.banners.index', [
            'banners' => Banner::all()
        ]);
    }

    public function store()
    {
        // Validate request
        $this->validate(request(), [
            'position' => ['required', 'in:top,bottom,side'],
            'file' => ['required', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        // Move file to folder
        $destination = 'banners';
        $transferFile = 'BN'.time().'.'.request('file')->getClientOriginalExtension();
        request('file')->move($destination, $transferFile);

        // Create banner
        Banner::create([
            'position' => request('position'), 'url' => $destination.'/'.$transferFile
        ]);
        return back()->with('success', 'Bannner created successfully');
    }

    public function update(Banner $banner)
    {
        // Validate request
        $this->validate(request(), [
            'position' => ['required', 'in:top,bottom,side'],
            'file' => ['sometimes', 'mimes:png,jpg,jpeg', 'max:2048']
        ]);

        // Upload file if exists
        $data = request()->only('position');
        if (request('file')){
            // Remove old file
            unlink($banner['url']);

            // Upload new file
            $destination = 'banners';
            $transferFile = 'BN'.time().'.'.request('file')->getClientOriginalExtension();
            request('file')->move($destination, $transferFile);
            $data['url'] = $destination.'/'.$transferFile;
        }

        // Update banner
        $banner->update($data);
        return back()->with('success', 'Bannner updated successfully');
    }

    public function destroy(Banner $banner)
    {
        // Remove old file
        unlink($banner['url']);
        $banner->delete();
        return back()->with('success', 'Bannner deleted successfully');
    }
}