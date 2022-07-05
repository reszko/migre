<?php

namespace App\Controllers;

use App\Models\LinkModel;
use App\Models\UsuarioModel;

class User extends BaseController
{

	protected $usuarioModel;
	protected $linkModel;

	public function __construct()
	{
		$this->usuarioModel = new UsuarioModel();
		$this->linkModel = new LinkModel();
	}


	/**
	 * Chama a view principal
	 *
	 * @return void
	 */
	public function index()
	{
		$this->linkModel->select('*,
				links.id as id_link,
				links.created_at as link_created_at,
				links.updated_at as link_updated_at
				');
		//Se não for admin, então só mostra os próprios links.
		if ((bool)session()->admin === false) {
			$this->linkModel->where('usuarios_id', session()->id);
		}

		$this->linkModel->join('usuarios', 'usuarios.id = links.usuarios_id', 'LEFT');
		$links = $this->linkModel->orderBy('clicks', 'desc')->orderBy('links.created_at', 'desc')->findAll();

		return view('meus_links', [
			'links' => $links,
			'totalClicks' => $this->linkModel->totalClicks()
		]);
	}

	/**
	 * Chama a view de alteração de senha
	 *
	 * @return void
	 */
	public function changePass()
	{
		return view('changepass');
	}

	/**
	 * Salva os dados do usuário
	 *
	 * @return void
	 */
	public function store()
	{
		$post = $this->request->getPost();
		// dd($post);
		if ($this->usuarioModel->save($post)) {
			return redirect()->to(base_url('login'))->with('message', [
				'tipo' => 'success',
				'message' => 'Cadastro efetuado com sucesso.'
			]);
		} else {
			return view('login', [
				'errors' => $this->usuarioModel->errors()
			]);
		}
	}
	/**
	 * Altera a senha do usuário
	 */
	public function updatePass()
	{
		$post = $this->request->getPost();
		if ($this->usuarioModel->save($post)) {
			return redirect()->to(base_url('user/changepass'))->with('message', [
				'tipo' => 'success',
				'message' => 'Senha alterada com sucesso.'
			]);
		} else {
			return view('changepass', [
				'errors' => $this->usuarioModel->errors()
			]);
		}
	}

	/**
	 * Chama a view para informar o email cadastrado
	 *
	 * @return void
	 */
	public function esqueciSenha()
	{
		return view('esqueciSenha');
	}

	/**
	 * Verifica se o usuário existe no banco de dados para resetar a senha.
	 *
	 * @return void
	 */
	public function checkSenha()
	{
		$email = $this->request->getPost('email');
		$dadosUsuario = $this->usuarioModel->getByEmail($email);

		if (is_null($dadosUsuario)) {
			return redirect()->to('/user/esqueciSenha')->with('message', [
				'tipo' => 'danger',
				'message' => "E-mail não encontrado no cadastro."
			]);
		} else {
			helper('text');
			$emailService = \Config\Services::email();
			$novaSenha = random_string('alnum', 8);
			$conteudo = view('emails/nova_senha', [
				'senha' => $novaSenha
			]);

			$emailService->setTo($email);
			$emailService->setSubject('Sua nova senha de acesso - ' . date('d/m/Y H:i:s'));
			$emailService->setMessage($conteudo);
			if ($emailService->send(false)) {
				//Atualizo a senha do usuário
				$this->usuarioModel->save([
					'id' => $dadosUsuario['id'],
					'senha' => $novaSenha
				]);
				return redirect()->to('/user/esqueciSenha')->with('message', [
					'tipo' => 'success',
					'message' => "Sucesso. Uma nova senha foi gerada e enviada para seu e-mail."
				]);
			} else {
				log_message('critical', 'ERRO ao enviar a mensagem para: ' . $email . ' - ' . $emailService->printDebugger('headers'));
				return redirect()->to('/user/esqueciSenha')->with('message', [
					'tipo' => 'danger',
					'message' => "ERRO - Não foi possível enviar o e-mail. Por favor, tente novamente."
				]);
			}
		}
	}
}
