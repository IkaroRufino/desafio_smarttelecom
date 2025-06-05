<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" id="form-cadastro">
            @csrf

            <!-- Cadastro de usuário -->
            <div id="form-usuario">
                <h3 class="text-lg font-semibold mb-4">Cadastro de Usuário</h3>

                <div>
                    <x-label for="name" value="Nome Completo" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="cpf" value="CPF" />
                    <x-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" required />
                </div>

                <div class="mt-4">
                    <x-label for="telefone" value="Telefone" />
                    <x-input id="telefone" class="block mt-1 w-full" type="text" name="telefone" :value="old('telefone')" required />
                </div>

                <div class="mt-4">
                    <x-label for="cargo" value="Cargo / Função" />
                    <x-input id="cargo" class="block mt-1 w-full" type="text" name="cargo" :value="old('cargo')" required />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="Senha" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="Confirme a Senha" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                </div>

                <!-- Checkbox: deseja criar provedor -->
                <div class="mt-4">
                    <label class="flex items-center">
                        <x-checkbox id="criar_provedor" name="criar_provedor" />
                        <span class="ml-2 text-sm text-gray-600">Deseja cadastrar seu provedor agora?</span>
                    </label>
                </div>

                <!-- Botão de próxima etapa -->
                <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        Já possui uma conta?
                    </a>
                    <x-button id="btn-proximo">
                        Próximo
                    </x-button>
                </div>
            </div>

            <!-- Cadastro de Provedor -->
            <div id="form-provedor" class="hidden">
                <h3 class="text-lg font-semibold mb-4">Cadastro do Provedor</h3>

                <div class="mb-3">
                    <x-label for="cnpj" value="CNPJ" />
                    <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')" />
                </div>

                <div class="mb-3">
                    <x-label for="site" value="Site (opcional)" />
                    <x-input id="site" class="block mt-1 w-full" type="text" name="site" :value="old('site')" />
                </div>

                <div class="mb-3">
                    <x-label for="telefone_comercial" value="Telefone Comercial" />
                    <x-input id="telefone_comercial" class="block mt-1 w-full" type="text" name="telefone_comercial" :value="old('telefone_comercial')" />
                </div>

                <div class="mb-2">
                    <h5 class="font-semibold">Endereço da Matriz</h5>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-label for="logradouro" value="Logradouro" />
                        <x-input id="logradouro" class="block mt-1 w-full" type="text" name="logradouro" />
                    </div>
                    <div>
                        <x-label for="numero" value="Número" />
                        <x-input id="numero" class="block mt-1 w-full" type="text" name="numero" />
                    </div>
                    <div>
                        <x-label for="complemento" value="Complemento" />
                        <x-input id="complemento" class="block mt-1 w-full" type="text" name="complemento" />
                    </div>
                    <div>
                        <x-label for="bairro" value="Bairro" />
                        <x-input id="bairro" class="block mt-1 w-full" type="text" name="bairro" />
                    </div>
                    <div>
                        <x-label for="cidade" value="Cidade" />
                        <x-input id="cidade" class="block mt-1 w-full" type="text" name="cidade" />
                    </div>
                    <div>
                        <x-label for="estado" value="Estado" />
                        <x-input id="estado" class="block mt-1 w-full" type="text" name="estado" />
                    </div>
                    <div class="col-span-2">
                        <x-label for="cep" value="CEP" />
                        <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" />
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex items-center justify-between mt-4">
                    <x-button id="btn-voltar" type="button">Voltar</x-button>
                    <x-button type="submit">Finalizar Cadastro</x-button>
                </div>
            </div>
        </form>

        <!-- Script para controlar o fluxo entre as etapas -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const criarProvedor = document.getElementById('criar_provedor');
                const formUsuario = document.getElementById('form-usuario');
                const formProvedor = document.getElementById('form-provedor');
                const btnProximo = document.getElementById('btn-proximo');
                const btnVoltar = document.getElementById('btn-voltar');

                btnProximo.addEventListener('click', function (e) {
                    // Se a pessoa marcou que vai criar provedor, mostra a o cadastro do provedor
                    if (criarProvedor.checked) {
                        e.preventDefault(); // evita envio do form
                        formUsuario.classList.add('hidden');
                        formProvedor.classList.remove('hidden');
                    }
                });

                btnVoltar?.addEventListener('click', function () {
                    formProvedor.classList.add('hidden');
                    formUsuario.classList.remove('hidden');
                });
            });
        </script>
    </x-authentication-card>
</x-guest-layout>
