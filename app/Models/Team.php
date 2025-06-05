<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * Atributos que podem ser atribuídos em massa.
     */
    protected $fillable = [
        'user_id',               // Dono do time
        'name',
        'cnpj',
        'site',
        'telefone_comercial',
        'endereco_matriz',
    ];

    /**
     * Eventos do Jetstream.
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Conversões de tipo.
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
            'endereco_matriz' => 'array', // Para acessar como array no código
        ];
    }

    /**
     * Dono do time.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Membros do time.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function teamsWithRoles()
    {
        return $this->belongsToMany(Team::class)
                    ->withPivot('role')
                    ->withTimestamps();
    }

}
