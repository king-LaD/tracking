<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::orderBy('created_at', 'desc')->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $statuses = Package::getPredefinedStatuses();
        return view('admin.packages.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_title'          => 'required|string|max:255',
            'client_name'            => 'required|string|max:255',
            'client_phone'           => 'nullable|string|max:20',
            'client_cni'             => 'nullable|string|max:50',
            'destination'            => 'required|string|max:255',
            'registration_date'      => 'required|date',
            'estimated_arrival_date' => 'nullable|date',
            'current_status'         => ['required', Rule::in(Package::getPredefinedStatuses())],
        ]);

        Package::create($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Colis créé avec succès.');
    }

    public function edit(Package $package)
    {
        $statuses = Package::getPredefinedStatuses();
        return view('admin.packages.edit', compact('package', 'statuses'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'client_name'       => 'required|string|max:255',
            'destination'       => 'required|string|max:255',
            'registration_date' => 'required|date',
            'current_status'    => ['required', Rule::in(Package::getPredefinedStatuses())],
        ]);

        $package->update($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Le colis a été intégralement mis à jour.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Colis supprimé.');
    }
}