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
    