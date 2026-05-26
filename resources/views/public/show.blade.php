@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-12 px-4 sm:px-6">
    
    @if(!$package)
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-8 sm:p-12 text-center">
            <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Expédition introuvable</h2>
            <p class="text-slate-500 mb-8 font-medium">La référence <span class="text-slate-900 font-bold">{{ $search_number }}</span> ne correspond à aucune donnée logistique.</p>
            <a href="{{ route('home') }}" class="inline-flex px-6 py-2.5 bg-slate-900 text-white font-semibold rounded-lg hover:bg-slate-800 transition-colors">Nouvelle recherche</a>
        </div>
    @else
        
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-8">
            <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Réf. Suivi</p>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $package->tracking_number }}</h1>
                    <p class="text-lg font-semibold text-slate-700 mt-1">{{ $package->package_title }}</p>
                </div>
                <div class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-bold border 
                    {{ $package->current_status == 'Livré' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-blue-50 text-blue-700 border-blue-200' }}">
                    <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $package->current_status == 'Livré' ? 'bg-green-600' : 'bg-blue-600' }}"></span>
                    {{ $package->current_status }}
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 bg-slate-50 divide-y md:divide-y-0 md:divide-x divide-slate-200">
                <div class="p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-200 pb-2">Données d'acheminement</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Destination</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $package->destination }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500">Date d'enregistrement</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $package->registration_date->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Arrivée estimée</p>
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $package->estimated_arrival_date ? $package->estimated_arrival_date->format('d/m/Y') : 'Non communiquée' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-200 pb-2">Destinataire</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Nom du client</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $package->client_name }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500">Téléphone</p>
                                <p class="text-sm font-semibold text-slate-900">{{ $package->client_phone ?? 'Non renseigné' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">N° CNI / ID</p>
                                <p class="text-sm font-mono font-semibold text-slate-900">{{ $package->client_cni ?? 'Non renseigné' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sm:p-8">
            <h2 class="text-lg font-bold text-slate-900 mb-8 border-b border-slate-100 pb-4">Historique des mouvements</h2>

            <div class="relative">
                <div class="absolute left-[15px] top-3 bottom-3 w-[2px] bg-slate-200"></div>

                <div class="space-y-0">
                    @forelse($package->events as $event)
                        <div class="relative pl-12 py-5 group">
                            
                            <div class="absolute left-[11px] top-[26px] w-[10px] h-[10px] rounded-full ring-4 ring-white z-10 
                                {{ $loop->first ? 'bg-blue-600' : 'bg-slate-300' }}">
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                                <div>
                                    <h3 class="text-base font-bold {{ $loop->first ? 'text-slate-900' : 'text-slate-700' }}">
                                        {{ $event->event_title ?? $event->status_description }}
                                    </h3>
                                    
                                    <div class="mt-1 flex items-center gap-2 text-sm">
                                        <span class="font-medium text-slate-600 bg-slate-100 px-2 py-0.5 rounded">{{ $event->status_description }}</span>
                                        @if($event->location)
                                            <span class="text-slate-400">&bull;</span>
                                            <span class="font-medium text-slate-500 uppercase tracking-wide">{{ $event->location }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-left sm:text-right shrink-0 mt-1 sm:mt-0">
                                    <time class="text-sm font-bold text-slate-600 tabular-nums block">
                                        {{ $event->event_date->format('d/m/Y') }}
                                    </time>
                                    <time class="text-xs font-semibold text-slate-400 tabular-nums">
                                        {{ $event->event_date->format('H:i') }}
                                    </time>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="pl-12 py-4 text-sm font-medium text-slate-500">
                            En attente de la première mise à jour logistique.
                        </div>
                    @endforelse

                    <div class="relative pl-12 py-5">
                        <div class="absolute left-[11px] top-[26px] w-[10px] h-[10px] rounded-full ring-4 ring-white z-10 bg-slate-200"></div>

                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                            <div>
                                <h3 class="text-base font-bold text-slate-500">Ouverture du dossier logistique</h3>
                                <div class="mt-1 flex items-center gap-2 text-sm">
                                    <span class="font-medium text-slate-500 bg-slate-50 px-2 py-0.5 rounded border border-slate-200">Enregistré</span>
                                </div>
                            </div>
                            <div class="text-left sm:text-right shrink-0 opacity-75">
                                <time class="text-sm font-bold text-slate-600 tabular-nums block">
                                    {{ $package->registration_date->format('d/m/Y') }}
                                </time>
                                <time class="text-xs font-semibold text-slate-400 tabular-nums">
                                    {{ $package->registration_date->format('H:i') }}
                                </time>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Rechercher un autre colis
                </a>
            </div>
        </div>
    @endif
</div>
@endsection