@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('admin.packages.index') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">
                    &larr; Retour à la liste
                </a>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                Dossier <span class="text-blue-600">#{{ $package->tracking_number }}</span>
            </h1>
            <p class="text-slate-500 mt-1 font-medium">Gestion de l'expédition et mise à jour de la timeline.</p>
        </div>
        <div>
            <a href="{{ route('tracking.track', ['tracking_number' => $package->tracking_number]) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Voir le suivi public
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-8 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            <div class="flex items-center gap-2 font-bold mb-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                Veuillez corriger les erreurs suivantes :
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Informations logistiques</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Titre / Description de l'expédition</label>
                        <input type="text" name="package_title" value="{{ old('package_title', $package->package_title) }}" required 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Destination</label>
                        <input type="text" name="destination" value="{{ old('destination', $package->destination) }}" required 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Statut Actuel</label>
                        <select name="current_status" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2.5 border text-slate-900 text-sm bg-white">
                            @foreach($statuses ?? ['En attente', 'Enregistré', 'En transit', 'En douane', 'Disponible pour retrait', 'Livré'] as $status)
                                <option value="{{ $status }}" @selected(old('current_status', $package->current_status) == $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Date d'enregistrement</label>
                        <input type="datetime-local" name="registration_date" value="{{ old('registration_date', $package->registration_date->format('Y-m-d\TH:i')) }}" required 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Date estimée d'arrivée</label>
                        <input type="date" name="estimated_arrival_date" value="{{ old('estimated_arrival_date', $package->estimated_arrival_date ? $package->estimated_arrival_date->format('Y-m-d') : '') }}" 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>
                </div>

                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6">Informations du Destinataire</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nom complet</label>
                        <input type="text" name="client_name" value="{{ old('client_name', $package->client_name) }}" required 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="client_phone" value="{{ old('client_phone', $package->client_phone) }}" 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">N° CNI / Passeport</label>
                        <input type="text" name="client_cni" value="{{ old('client_cni', $package->client_cni) }}" 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm font-mono">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg shadow-sm transition-colors">
                        Mettre à jour le dossier
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            
            <div class="bg-blue-50/50 p-6 sm:p-8 rounded-2xl shadow-sm border border-blue-100">
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter une étape
                </h2>

                <form action="{{ route('admin.packages.events.store', $package->id) }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Titre de l'étape <span class="text-red-500">*</span></label>
                        <input type="text" name="event_title" value="{{ old('event_title') }}" required placeholder="Ex: Arrivée en douane" 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Catégorie / Statut <span class="text-red-500">*</span></label>
                        <select name="status_description" required class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2.5 border text-slate-900 text-sm bg-white">
                            @foreach($statuses ?? ['En attente', 'Enregistré', 'En transit', 'En douane', 'Disponible pour retrait', 'Livré'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Localisation (Optionnel)</label>
                        <input type="text" name="location" value="{{ old('location') }}" placeholder="Ex: Port autonome de Douala" 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Date et Heure <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="event_date" value="{{ old('event_date', now()->format('Y-m-d\TH:i')) }}" required 
                               class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent shadow-sm px-4 py-2 border text-slate-900 text-sm">
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors mt-2">
                        Enregistrer l'étape
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Étapes enregistrées ({{ $package->events->count() }})</h3>
                <div class="space-y-4 max-h-64 overflow-y-auto pr-2">
                    @forelse($package->events as $event)
                        <div class="flex gap-3 pb-4 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                            <div class="mt-1">
                                <span class="w-2 h-2 rounded-full bg-slate-300 block"></span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $event->event_title ?? $event->status_description }}</p>
                                <p class="text-xs font-semibold text-slate-500 mt-0.5">{{ $event->event_date->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500 italic">Aucune étape pour le moment.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection