<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Package extends Model
{
    protected $fillable = [
        'tracking_number',
        'client_name',
        'destination',
        'current_status',
        'registration_date'
    ];

    protected $casts = [
        'registration_date' => 'datetime',
    ];

    // Liste centralisée des statuts autorisés dans l'application
    public static function getPredefinedStatuses(): array
    {
        return [
            'En attente',
            'Enregistré',
            'Embarqué',
            'En transit',
            'Débarqué',
            'En douane',
            'Disponible pour retrait',
            'Livré'
        ];
    }

    // Événement Eloquent pour automatiser la création du numéro de suivi unique
    protected static function booted()
    {
        static::creating(function ($package) {
            do {
                // Génère un format : TG - Année Courante - 6 caractères aléatoires majuscules
                $number = 'TG-' . date('Y') . '-' . strtoupper(Str::random(6));
            } while (static::where('tracking_number', $number)->exists());

            $package->tracking_number = $number;
        });
    }

    // Relation : Un colis possède plusieurs événements chronologiques
    public function events(): HasMany
    {
        return $this->hasMany(PackageEvent::class)->orderBy('event_date', 'desc');
    }
}
