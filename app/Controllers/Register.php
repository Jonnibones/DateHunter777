<?php

namespace App\Controllers;

class Register extends BaseController
{
    public function index()
    {
        $session = session();

        $info['title'] = 'Cadastre-se';
        $info['erros'] = '';
        return view('register_view',$info);
    
    }

    public function insert()
    {
        $session = session();
        
        if($_POST['g-recaptcha-response'] == '')
        {
            $session->setFlashdata('msg', 'Campo do recaptcha não foi marcado');
            return redirect()->to('/register');
        }

        $captcha_data = $_POST['g-recaptcha-response'];                                       
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcPDngfAAAAAG8v-d75rsPJ5WrgqqvcAvYiXRYH&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);

        if(!$response)
        {
            return redirect()->to('/register');
        }
        else
        {
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
                    return redirect()->to('register');
                }
                else
                {
                    $info['erros'] = $UsersModel->errors();
                    $info['values'] = $this->request->getPost();
                }

            }
        }

        return redirect()->to('login');

    }

}