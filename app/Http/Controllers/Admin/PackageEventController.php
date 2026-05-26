<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PackageEventController extends Controller
{
    public function store(Request $request, Package $package)
    {
        $validated = $request->validate([
            'status_description' => ['required', Rule::in(Package::getPredefinedStatuses())],
            'location'           => 'nullable|string|max:255',
            'event_date'         => 'required|date',
        ]);

        $package->events()->create($validated);

        // Synchronise automatiquement le statut général du colis avec le dernier événement ajouté
        $package->update(['current_status' => $request->status_description]);

        return redirect()->back()->with('success', 'Nouvel événement enregistré.');
    }

    public function update(Request $request, PackageEvent $event)
    {
        $validated = $request->validate([
            'status_description' => ['required', Rule::in(Package::getPredefinedStatuses())],
            'location'           => 'nullable|string|max:255',
            'event_date'         => 'required|date', // Permet de réécrire l'heure et la date de l'événement
        ]);

        $event->update($validated);

        // Met à jour le statut global si cet événement modifié est le plus récent chronologiquement
        $latestEvent = $event->package->events()->first();
        if ($latestEvent && $latestEvent->id === $event->id) {
            $event->package->update(['current_status' => $event->status_description]);
        }

        return redirect()->back()->with('success', 'Événement mis à jour avec précision.');
    }

    public function destroy(PackageEvent $event)
    {
        $package = $event->package;
        $event->delete();

        // Réajuste le statut global après suppression
        $latestEvent = $package->events()->first();
        if ($latestEvent) {
            $package->update(['current_status' => $latestEvent->status_description]);
        }

        return redirect()->back()->with('success', 'Événement supprimé.');
    }
    
}
