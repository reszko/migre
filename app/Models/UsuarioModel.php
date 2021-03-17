<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $allowedFields = [
        'email',
        'senha'
    ];
    protected $useTimestamps = true;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected $validationRules = [
        'email' => [
            'label' => 'E-mail',
            'rules' => 'required|is_unique[usuarios.email]',
            'errors' => [
                'is_unique' => 'O e-mail {value} já está cadastrado'
            ]
        ],
        'senha' => [
            'label' => 'Senha',
            'rules' => 'required|min_length[5]'
        ],
        'senha_confirm' => [
            'label' => 'Repita a Senha',
            'rules' => 'required[senha]|matches[senha]|min_length[5]'
        ]
    ];

    /**
     * Faz o hash do password
     *
     * @param [type] $data
     * @return void
     */
    protected function hashPassword($data)
    {
        $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_BCRYPT);

        return $data;
    }

    /**
     * Retorna um usuário pelo seu e-mail
     *
     * @param string $email
     * @return void
     */
    public function getByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}
