<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AutenticadorService
{
    public function autenticar(string $email, string $password)
    {
        // Vai buscar o usuário pelo seu e-mail
        $usuario = User::where('email', $email)->first();

        // Inicia autenticação do usuário
        if (!$usuario || !Hash::check($password, $usuario->password)) {
            // se não passa vai retornar uma Exception para o AutenticadorController
            throw ValidationException::withMessages(['email' => ['Verifique as credenciais!']]);
        }

        // Se passar gera o token
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return [
            'token'   => $token,
            'usuario' => $usuario
        ];
    }

    public function dadosUsuario(User $usuario): array
    {
        return [
            'id'    => $usuario->id,
            'nome'  => $usuario->name,
            'email' => $usuario->email,
        ];
    }

    public function limparToken(User $usuario)
    {
        $usuario->tokens()->delete();
    }

    public function registrarUsuario(array $dados)
    {
        // Verifica se o e-mail para cadastro já existe
        $email = User::where('email', $dados['email'])->exists();
        if ($email) {
            throw ValidationException::withMessages(['email' => ['Já existe um e-mail cadastrado em nosso sistema.']]);
        }

        // Criando o usuario 
        $usuario = User::create([
            'name'     => $dados['name'],
            'email'    => $dados['email'],
            'password' => Hash::make($dados['password']),
        ]);

        // Vai gerar o token e retornar os dados para o AutenticadorController
        $token = $usuario->createToken('auth_token')->plainTextToken;
        return [
            'id'         => $usuario->id,
            'nome'       => $usuario->name,
            'email'      => $usuario->email,
            'token'      => $token,
            'token_type' => 'Bearer'
        ];
    }
}
