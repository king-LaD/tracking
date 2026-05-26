@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Colis</h1>
            <p class="text-gray-500">Liste exhaustive de toutes les expéditions actives.</p>
        </div>
        <a href="{{ route('admin.packages.create') }}" class="bg-gray-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-800 transition">
            Nouveau Colis
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Numéro / Client</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Destination</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400">Statut</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($packages as $package)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $package->tracking_number }}</div>
                        <div class="text-sm text-gray-500">{{ $package->client_name }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $package->destination }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 uppercase italic">
                            {{ $package->current_status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="text-gray-400 hover:text-blue-600">Modifier</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection