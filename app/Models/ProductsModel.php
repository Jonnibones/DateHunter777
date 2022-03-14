<?php

    namespace App\Models;

    use CodeIgniter\Model;

    class ProductsModel extends Model
    {
        protected $table = 'tb_product';
        protected $primaryKey = 'id';
        protected $useAutoIncrement = true;
        protected $allowedFields = ['name_product', 'date_exp_product', 'date_not_product', 'observ_product', 'id_user'];
        protected $returnType = 'array';

        protected $validationRules = [
        
            'name_product'            => 'required|alpha_numeric_punct',
            'date_exp_product'        => 'required',
            'date_not_product'        => 'required',

        ];

        protected $validationMessages = [
        
            'name_product' => [
                'required' => 'O campo Nome do produto, não pode ser vazio.',
                'alpha_numeric_punct' => 'Caracteres não permitidos.'
            ],

            'date_exp_product' => [
                'required' => 'O campo Data de validade, não pode ser vazio.'
            ],

            'date_not_product' => [
                'required' => 'O campo Data de notificação, não pode ser vazio.'
            ],


        ];
 
    }
    
?>