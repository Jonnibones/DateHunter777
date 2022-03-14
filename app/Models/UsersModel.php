<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class UsersModel extends Model
    {
        protected $table = 'tb_user';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $allowedFields = ['id_user','name_user','email_user', 'pass_user'];
        protected $returnType = 'array';

        protected $validationRules = [

            'name_user'  => 'required|min_length[3]|alpha_numeric',
            'email_user' => 'required|min_length[10]|is_unique[tb_user.email_user]',
            'pass_user'  => 'required|min_length[6]'
    
        ];

        protected $validationMessages = [
            'name_user' => [
                'required' => 'O campo Nome é obrigatório.',
                'min_length' => 'Insira um nome com no mínimo 3 caracteres.',
                'alpha_numeric' => 'Este campo não aceita caracteres especiais'
            ],

            'email_user' => [
                'required' => 'O campo E-mail é obrigatório.',
                'min_length' => 'Insira um E-mail com no mínimo 10 caracteres.',
                'is_unique' => 'E-mail já cadastrado.'
            ],

            'pass_user' => [
                'required' =>  'O campo Senha é obrigatório.',
                'min_length' => 'Insira uma senha com no mínimo 8 caracteres.'
            ]

        ];
        
    }


?>