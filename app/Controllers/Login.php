<?php

namespace App\Controllers;

use App\Models\LinkModel;
use App\Models\UsuarioModel;

class Login extends BaseController
{

	protected $usuarioModel;
	protected $linkModel;

	public function __construct()
	{
		$this->usuarioModel = new UsuarioModel();
		$this->linkModel = new LinkModel();
	}

	/**
	 * Chama a view de login/cadastro
	 *
	 * @return void
	 */
	public function index()
	{
		return view('login');
	}

	/**
	 * Faz o signin do usuário
	 *
	 * @return void
	 */
	public function signin()
	{
		$post = $this->request->getPost();
		$dadosUsuario = $this->usuarioModel->getByEmail($post['email_login']);
		if (!is_null($dadosUsuario)) {
			$passHash = $dadosUsuario['senha'];
			if (password_verify($post['senha_login'], $passHash)) {
				session()->set([
					'isLoggedIn' => true,
					'id' => $dadosUsuario['id'],
					'admin' => $dadosUsuario['admin'],
					'email' => $dadosUsuario['email']
				]);
				//Se o login foi com sucesso.
				return redirect()->to(base_url('user'))->with('message', [
					'tipo' => 'success',
					'message' => 'Você está logado'
				]);
			}
		}

		return redirect()->to(base_url('login'))->with('error_login', 'Usuário/Senha não correspondem.');
	}

	/**
	 * Desloga o usuário
	 *
	 * @return void
	 */
	public function signout()
	{
		session()->destroy();
		return redirect()->to(base_url());
	}
}
