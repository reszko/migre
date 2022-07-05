<?php

namespace App\Controllers;

use App\Models\LinkModel;
use Hashids\Hashids;

class Link extends BaseController
{

	protected $linkModel;
	protected $hashids;
	public function __construct()
	{
		$this->linkModel = new LinkModel();
		$this->hashids = new Hashids();
	}

	/**
	 * Localiza a URL e rediciona pra ela
	 *
	 * @param [type] $url
	 * @return void
	 */
	public function redirect($hash)
	{
		$rq = $this->linkModel->getByHash($hash);

		if (!is_null($rq)) {
			//Incrementa o campo clicks para estatísticas
			$this->linkModel->incrementaClick($rq['id'], $rq['clicks']);
			//Redireciona para o link original
			return redirect()->to($rq['link_original']);
		}

		return redirect()->to(base_url())->with('message', [
			'tipo' => 'danger',
			'message' => 'Oooops. Endereço não encontrado...'
		]);
	}

	/**
	 * Recebe o post do formulário e cria o link encurtado
	 * O código do link é gerado a partir do hashids, que recebe o maior id disponivel na tabela de links.
	 * Este valor nunca pode se repetir. Se isto ocorrer, não se deve dexar criar o link sob o risco de um mesmo
	 * link encurtado apontar para um outro link já existente.
	 *
	 * @return void
	 */
	public function store()
	{
		$post = $this->request->getPost();
		$lastId = (int)$this->linkModel->getLastId();
		$hash = $this->hashids->encode($lastId);
		$link_encurtado = site_url($hash);

		$data = [
			'link_original' => $post['link_original'],
			'link_encurtado' => $link_encurtado,
			'usuarios_id' => session()->has('id') ? session()->id : null
		];

		//Antes de salvar, verifico se este valor já existe na tabela.
		//Se existir, não deixo continar em nenhuma hipótese
		if (is_null($this->linkModel->getByHash($hash))) {
			if ($this->linkModel->save($data)) {
				return redirect()->to(base_url())->with('messages', [
					'message' => 'SUCESSO! Este é seu link encurtado',
					'link_encurtado' => $link_encurtado,
					'link_original' => $post['link_original']
				]);
			} else {
				return view('home', [
					'errors' => $this->linkModel->errors()
				]);
			}
		} else {
			return redirect()->to(base_url())->with('error', [
				'tipo' => 'danger',
				'message' => 'ERRO - Este link encurtado já existe, por favor, tente novamente.'
			]);
		}
	}

	/**
	 * Exclui um link do usuário logado
	 * Não permito a exclusão de um link de outro usuário, a menos que o usuário logado seja admin
	 *
	 * @param [type] $id
	 * @return void
	 */
	public function delete($id)
	{
		//Se for admin, permito a exclusão de links de outros usuários.
		if ((bool)session()->admin === true) {
			if ($this->linkModel->delete($id)) {
				return redirect()->to(base_url('user'))->with('message', [
					'tipo' => 'info',
					'message' => 'Link excluído com sucesso.'
				]);
			}
		}

		//Se não for dono, não permito exclusão.
		if (is_null($this->linkModel->where('usuarios_id', session()->id)->find($id))) {
			return redirect()->to(base_url('user'))->with('message', [
				'tipo' => 'danger',
				'message' => '[ERRO] - Link não encontrado ou o link pertence a outro usuário.'
			]);
		}

		//Se for dono do link, permito exclusão
		if ($this->linkModel->where('usuarios_id', session()->id)->delete($id)) {
			return redirect()->to(base_url('user'))->with('message', [
				'tipo' => 'info',
				'message' => 'Link excluído com sucesso.'
			]);
		}
	}
}
