<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rules;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:20'],
            'telefone' => ['required', 'string', 'max:20'],
            'cargo' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),

            // Campos opcionais do provedor
            'criar_provedor' => ['nullable'],
            'cnpj' => ['nullable', 'string', 'max:20'],
            'telefone_comercial' => ['nullable', 'string', 'max:20'],
            'site' => ['nullable', 'string', 'max:255'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
            'cep' => ['nullable', 'string', 'max:20'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            // Criação do usuário
            $user = User::create([
                'name' => $input['name'],
                'cpf' => $input['cpf'],
                'telefone' => $input['telefone'],
                'cargo' => $input['cargo'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            // Se for criar provedor, cria o time associado
            if (!empty($input['criar_provedor'])) {
                $team = Team::create([
                    'user_id' => $user->id,
                    'name' => $user->name . ' - Provedor',
                    'cnpj' => $input['cnpj'] ?? null,
                    'site' => $input['site'] ?? null,
                    'telefone_comercial' => $input['telefone_comercial'] ?? null,
                    // assumindo que endereco_matriz é um campo JSON na migration da tabela teams
                    'endereco_matriz' => json_encode([
                        'logradouro' => $input['logradouro'] ?? '',
                        'numero' => $input['numero'] ?? '',
                        'complemento' => $input['complemento'] ?? '',
                        'bairro' => $input['bairro'] ?? '',
                        'cidade' => $input['cidade'] ?? '',
                        'estado' => $input['estado'] ?? '',
                        'cep' => $input['cep'] ?? '',
                    ]),
                ]);

                $user->current_team_id = $team->id;
                $user->save();

                // Anexar o usuário ao time com role 'owner' (ajuste se o relacionamento for diferente)
                $team->users()->attach($user->id, ['role' => 'owner']);
            }

            return $user;
        });
    }
}
