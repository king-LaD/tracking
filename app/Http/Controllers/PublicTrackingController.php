<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PublicTrackingController extends Controller
{
    public function index()
    {
        return view('public.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $package = Package::where('tracking_number', $request->tracking_number)
            ->with(['events'])
            ->first();

        return view('public.show', compact('package'))->with('search_number', $request->tracking_number);
    }
}
