<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        $productModel = new \App\Models\ProductsModel();
        $userModel = new \App\Models\UsersModel();
        $email = \Config\Services::email();

        $today = date('Y-m-d');

        $results = $productModel->db->query(
            "SELECT * FROM tb_product
            WHERE date_not_product <= '$today'
            AND date_exp_product >= '$today' "
        );

        $result = $results->getResult('array');


        $to      = 'nobody@example.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = array(
        'From' => 'webmaster@example.com'
        );

        var_dump(mail($to, $subject, $message, $headers));


        /*
        foreach ($result as $row) 
        {
            $id_user = $row['id_user'];

            $results_user =  $userModel->db->query(
            "SELECT 
            email_user FROM tb_user
            WHERE id_user = $id_user");

            $ids_users = $results_user->getResult('object'); 

            $dataVal = strtotime($row['date_exp_product']);
            $dataAtual = strtotime(date('d-m-Y'));

            $difference = $dataVal - $dataAtual;

            $email->setFrom('Jonathan@datehunter777.xyz', 'Date Hunter 777');
            $email->setTo($ids_users[0]->email_user);
            //email->setCC('another@another-example.com');
            //$email->setBCC('them@their-example.com');
            
            $email->setSubject("O ".$row['name_product']." Produto próximo ao vencimento");
            $email->setMessage("Daqui a: ".date('d',$difference)." dias, o produto ".$row['name_product']."
            vai vencer. Data de validade: ".date_format(date_create($row['date_exp_product']),'d-m-Y')." Observação: ".$row['observ_product']);
            
            $email->send();
        }
        */
        return view('login_view');
    }
}
