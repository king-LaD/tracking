@extends('layouts.app')

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center bg-slate-50 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-2xl text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
            Suivi des Expéditions
        </h1>
        <p class="text-base text-slate-500 mb-10 font-medium">
            Saisissez votre numéro de référence Tracking Guest pour consulter l'état de votre livraison.
        </p>
        
        <form action="{{ route('tracking.track') }}" method="GET" class="relative max-w-xl mx-auto">
            <div class="relative flex items-center">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                
                <input type="text" name="tracking_number" placeholder="Numéro de suivi (ex: TG-2026-...)" required
                       class="block w-full pl-12 pr-32 py-4 text-base text-slate-900 bg-white border border-slate-300 rounded-xl shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all duration-200">
                
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                    Rechercher
                </button>
            </div>
        </form>
        
        <div class="mt-8 flex items-center justify-center gap-6 text-sm text-slate-500 font-medium">
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Temps réel</span>
            <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Sécurisé</span>
        </div>
    </div>
</div>
@endsection