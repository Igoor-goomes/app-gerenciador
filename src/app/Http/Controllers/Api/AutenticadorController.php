<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AutenticadorService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class AutenticadorController extends Controller
{
    protected AutenticadorService $autenticador;

    public function __construct(AutenticadorService $autenticador)
    {
        $this->autenticador = $autenticador;
    }

    /**
     * POST /api/login
     * Recebe e-mail/senha e devolve token Bearer.
     */
    public function login(Request $request)
    {
        $dados = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        try {
            $retorno = $this->autenticador->autenticar(
                $dados['email'],
                $dados['password']
            );


        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Verifique suas credenciais!',
                'erros'   => $e->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message'    => 'Login efetuado com sucesso!',
            'token'      => $retorno['token'],
            'token_type' => 'Bearer',
            'usuario'    => [
                'id'    => $retorno['usuario']->id,
                'nome'  => $retorno['usuario']->name,
                'email' => $retorno['usuario']->email
            ]
        ], Response::HTTP_OK);
    }
    
    /**
     * GET /api/dados
     * Retorna informações do usuário que foi autenticado | (Precisar enviar o Authorization: Bearer <token>)
     */
    public function dados(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'usuario' => $this->autenticador->dadosUsuario($user),
        ], Response::HTTP_OK);
    }


    /**
     * POST /api/logout
     * Remove o token válido do usuário autenticado
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $this->autenticador->limparToken($user);
        return response()->json([
            'message' => 'Logout realizado. Token revogado.',
        ], Response::HTTP_OK);
    }


    public function registrar(Request $request)
    {
        $dadosCadastro = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $usuario = $this->autenticador->registrarUsuario($dadosCadastro);
        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'usuario' =>$usuario
        ], Response::HTTP_CREATED);
    }
}
