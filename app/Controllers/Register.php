<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
    {
        $session = session();

        $info['title'] = 'Cadastre-se';
        $info['erros'] = '';
        
        if ($this->request->getMethod() === 'post') 
        {
            $UsersModel = new \App\Models\UsersModel();

            $inputs = $this->request->getPost();

            $inputs['pass_user'] = password_hash($this->request->getPost('pass_user'), PASSWORD_DEFAULT);

            
            $numRows = $UsersModel->findAll();
            
            if(count($numRows) >= 3)
            {
                $session->setFlashdata('msghidden', 'Permissão negada.');
                return redirect()->to('register');
            }

            if ($UsersModel->insert($inputs))
            {
                $session->setFlashdata('msghidden', 'Cadastro efetuado com sucesso.');
            }
            else
            {
                $info['erros'] = $UsersModel->errors();
                $info['values'] = $this->request->getPost();
            }

        }
        return view('register_view',$info);
    }

    

}