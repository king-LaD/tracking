@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer un Nouveau Colis</h1>
        <p class="text-gray-500">Enregistrez une nouvelle expédition avec les détails du client.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-700 text-sm">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.packages.store') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 space-y-8">
        @csrf

        <div>
            <h2 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informations de l'expédition</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Titre / Description du colis</label>
                    <input type="text" name="package_title" value="{{ old('package_title') }}" required placeholder="Ex: Véhicule Toyota Rav4 2020" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Destination</label>
                    <input type="text" name="destination" value="{{ old('destination') }}" required placeholder="Ex: Port de Douala" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Statut Initial</label>
                    <select name="current_status" required class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('current_status') == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Date d'enregistrement</label>
                    <input type="datetime-local" name="registration_date" required value="{{ old('registration_date', now()->format('Y-m-d\TH:i')) }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Date estimée d'arrivée</label>
                    <input type="date" name="estimated_arrival_date" value="{{ old('estimated_arrival_date') }}" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informations du Client</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Nom complet</label>
                    <input type="text" name="client_name" value="{{ old('client_name') }}" required placeholder="Ex: Jean Dupont" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Téléphone</label>
                    <input type="text" name="client_phone" value="{{ old('client_phone') }}" placeholder="Ex: +33 6 12 34 56 78" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Numéro CNI / Passeport</label>
                    <input type="text" name="client_cni" value="{{ old('client_cni') }}" placeholder="Ex: 123456789" 
                           class="w-full rounded-lg border-gray-300 focus:ring-blue-500 shadow-sm px-4 py-2 border">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6">
            <button type="submit" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm">
                Enregistrer le colis
            </button>
        </div>
    </form>
</div>
@endsection