<?php

namespace App\Controllers;

class Dashboard extends BaseController
{

    public function index()
    {
        $session = session();

        if (!isset($_SESSION['logged']) || $_SESSION['logged'] === false) 
        {
            $session->setFlashdata('msg', 'Acesso restrito');
            return redirect()->to('/login');
        }

        $productModel = new \App\Models\ProductsModel();
        $userModel = new \App\Models\UsersModel();

        $infos['title'] = 'Dashboard';

        $id = $_SESSION['id_user'];

        $results = $productModel->db->query(
            "SELECT 
            p.id, 
            p.name_product, 
            p.date_exp_product, 
            p.date_not_product, 
            p.observ_product 
            FROM db_datehunter.tb_product AS p 
            WHERE p.id_user = $id 
            ORDER BY date_exp_product ASC"
        );

        $result = $results->getResult('array');

        $user = $userModel->first($_SESSION['id_user']);

        foreach($result as $row)
        {
            // Verificação para envio de e-mail
           if (date('Y-m-d') >= $row['date_not_product'] && date('Y-m-d') <= $row['date_exp_product'] ) 
           {

               $dataVal = strtotime($row['date_exp_product']);
               $dataAtual = strtotime(date('d-m-Y'));

               $difference = $dataVal - $dataAtual;

               echo "<h3> e-mail: Daqui a: ".date('d',$difference)." dias o produto ".$row['name_product']."
               vai vencer. <br> Data de validade: ".date_format(date_create($row['date_exp_product']), 'd-m-Y')." <br>Observação: ".$row['observ_product'].".<br> Código do produto: ".$row['id']. "</h3>" ;

                //Retirar os echos acima e os comentários abaixo quando em produção

               $email = \Config\Services::email();

               $email->setFrom('E-mail da hospedagem', 'Date Hunter 777');
               $email->setTo($user['email_user']);
               //email->setCC('another@another-example.com');
               //$email->setBCC('them@their-example.com');
               
               $email->setSubject('Produto próximo ao vencimento');
               $email->setMessage("Daqui a: ".date('d',$difference)." dias, o produto ".$row['name_product']."
               vai vencer. Data de validade: ".$row['date_exp_product']." Observação: ".$row['observ_product']);

               //$email->send();
               
           }
        }

        $infos['products'] = $results->getResult('array');

        return view('dashboard_view', $infos);
    }

    public function inserir()
    {
        $info['title'] = 'Inserir Produto';
        $info['h1'] = 'Inserir produto';
        $info['msg'] = '';
        $info['button'] = 'Registrar';
        $info['errors'] = null; 

        if($this->request->getPost() != null)
        {
            $info['inputs'] = [
                $this->request->getPost()['name_product'], 
                $this->request->getPost()['date_exp_product'], 
                $this->request->getPost()['date_not_product'], 
                $this->request->getPost()['observ_product']
                ];

        }
       
        $session = session();

        if (isset($_SERVER['HTTP_REFERER'])) 
        {
            
            $productModel = new \App\Models\ProductsModel();

            if ($this->request->getMethod() === 'post') 
            {   
               
                if ($this->request->getPost()['date_exp_product'] <= date('Y-m-d') && $this->request->getPost()['date_exp_product'] != '') 
                {
                    $session->setFlashdata('msg', 'O campo data de validade não pode ser anterior ou igual a data atual.');
                    return view('form_product_view', $info);
                }
                
                if ($this->request->getPost()['date_not_product'] >= $this->request->getPost()['date_exp_product'] && $this->request->getPost()['date_not_product'] != '' ) 
                {
                    $session->setFlashdata('msg', 'O campo data de notificação tem que ser anterior a data de validade.');
                    return view('form_product_view', $info);
                }

                if ($this->request->getPost()['date_not_product'] <= date('Y-m-d') && $this->request->getPost()['date_not_product'] != '' ) 
                {
                    $session->setFlashdata('msg', 'O campo data de notificação tem que ser posterior a data atual.');
                    return view('form_product_view', $info);
                }

                if ($productModel->insert($this->request->getPost()))
                {
                    $info['msg'] = 'Inserido com sucesso!!';
                    unset($info['inputs']);
                }
                else
                {
                    $info['errors'] = $productModel->errors();
                }
            }

            return view('form_product_view', $info);
        }
        
        $session->setFlashdata('msg', 'Acesso Restrito!');
        return redirect()->to('/login'); 
        
    }

    public function editar()
    {
        $session = session();
        $info['title']  = 'Editar Produto';
        $info['h1']     = 'Editar produto';
        $info['msg']    = '';
        $info['button'] = 'Editar';
        $info['errors'] = null;

        $id = $this->request->getUri()->getSegment(3);

        if ($id == '') 
        {
            return redirect()->to('/dashboard');
        }
        
        $productModel = new \App\Models\ProductsModel();

        $product = $productModel->find($id);

        if ($product == null) {
            return redirect()->to('/dashboard');
        }

        $info['dados_produto'] = 
        [
            'nome'     => $product['name_product'],
            'date_exp' => $product['date_exp_product'],
            'date_not' => $product['date_not_product'],
            'observ'   => $product['observ_product']
        ];

        if ($this->request->getMethod() === 'post') 
        {
            if($this->request->getPost()['name_product'] == '' || $this->request->getPost()['date_exp_product'] == '' || $this->request->getPost()['date_not_product'] == '') 
            {
                $session->setFlashdata('msg', 'Campos não podem ser vazios.');
                return view('form_product_view', $info);
            }

            if ($this->request->getPost()['date_exp_product'] <= date('Y-m-d') && $this->request->getPost()['date_exp_product'] != '') 
            {
                $session->setFlashdata('msg', 'O campo data de validade não pode ser anterior ou igual a data atual.');
                return view('form_product_view', $info);
            }
            
            if ($this->request->getPost()['date_not_product'] >= $this->request->getPost()['date_exp_product'] && $this->request->getPost()['date_not_product'] != '' ) 
            {
                $session->setFlashdata('msg', 'O campo data de notificação tem que ser anterior a data de validade.');
                return view('form_product_view', $info);
            }

            if ($this->request->getPost()['date_not_product'] <= date('Y-m-d') && $this->request->getPost()['date_not_product'] != '' ) 
            {
                $session->setFlashdata('msg', 'O campo data de notificação tem que ser posterior a data atual.');
                return view('form_product_view', $info);
            }

            $productModel->update($id, $this->request->getPost());
            unset($info['dados_produto']);
            $info['msg'] = 'Atualizado com sucesso!!';
            $session->setFlashdata('msg', 'Atualizado com sucesso!!');
            return redirect()->to('/dashboard',);
        }
        
        return view('form_product_view', $info);

    }

    public function deletar()
    {
        $session = session();
        $id = $this->request->getUri()->getSegment(3);

        if ($id == '') 
        {
            return redirect()->to('/dashboard');
        }

        $productModel = new \App\Models\ProductsModel();

        if($productModel->delete($id))
        {
            $session->setFlashdata('msg', 'Registro Deletado com sucesso!!');
            return redirect()->to('/dashboard',);
        }

        return redirect()->to('/dashboard');
    } 
    
}
    