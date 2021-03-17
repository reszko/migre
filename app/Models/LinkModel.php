<?php

namespace App\Models;

use CodeIgniter\Model;

class LinkModel extends Model
{
    protected $table = 'links';
    protected $allowedFields = [
        'link_original',
        'link_encurtado',
        'usuarios_id',
        'clicks'
    ];
    protected $useTimestamps = true;

    protected $validationRules = [
        'link_original' => [
            'label' => 'URL',
            'rules' => 'required|valid_url|min_length[10]'
        ]
    ];

    /**
     * Retorna o maior ID registrado na tabela.
     *
     * @return void
     */
    public function getLastId(): int
    {
        $rq = $this->selectMax('id')->first()['id'];
        return !is_null($rq) ? ++$rq : 1;
    }

    /**
     * Localiza o link encurtado pelo seu hash
     *
     * @param [type] $hash
     * @return void
     */
    public function getByHash($hash)
    {
        return $this->where('link_encurtado', site_url($hash))->first();
    }


    /**
     * Incrementa a contagem de clicks.
     * Para não fazer nova consulta ao banco, recebo a contagem atual de clicks para atualizar.
     * @param [type] $id
     * @param [type] $clicksAtual
     * @return void
     */
    public function incrementaClick(int $id, int $clicksAtual)
    {
        return $this->where('id', $id)->save([
            'id' => $id,
            'clicks' => ++$clicksAtual
        ]);
    }
}
