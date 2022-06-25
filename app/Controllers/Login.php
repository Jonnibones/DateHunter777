<?php

namespace App\Controllers;

use Tests\Support\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        $session = session();
        
        session_destroy();

        $infos['title'] = 'Entrar';
        return view('login_view', $infos);
       
    }

    public function auth()
    {
        $session = session(); 

        if($_POST['g-recaptcha-response'] == '')
        {
            $session->setFlashdata('msg', 'Campo do recaptcha não foi marcado');
            return redirect()->to('/login');
        }

        $captcha_data = $_POST['g-recaptcha-response'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcPDngfAAAAAG8v-d75rsPJ5WrgqqvcAvYiXRYH&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);

        if(!$response)
        {
            return redirect()->to('/login');
        }
        else
        {
            if ($this->request->getMethod() === 'post') 
            {
                $userModel = new \App\Models\UsersModel();

                    $email = $this->request->getVar('inp_email');
                    $password = $this->request->getVar('inp_pass');

                    if($email == '' || $password == '')
                    {
                        $session->setFlashdata('msg', 'Campos não podem ser vazios.');
                        return redirect()->to('/login');
                    }

                    $data = $userModel->where('email_user', $email)->first();

                if($data) 
                {
                    $pass = $data['pass_user'];
                    $verify_pass = password_verify($password, $pass);

                    if ($verify_pass) 
                    {

                        $new_data = [

                            'id_user' => $data['id_user'],
                            'name_user' => $data['name_user'],
                            'email_user' => $data['email_user'],
                            'level_user' => $data['level_user'],
                            'logged' => TRUE

                        ];

                        $session->set($new_data);
                        return redirect()->to('/dashboard');
                    }
                    else
                    {
                        //exibir uma mensagem de senha errada e redirecionar para o formulário de login
                        $session->setFlashdata('msg', 'Senha errada.');
                        return redirect()->to('/login');
                    }
                }
                else
                {
                    //exibir uma mensagem de nenhum usuário encontrado e redirecionar para o formulário de login
                    $session->setFlashdata('msg', 'Nenhum registro com este e-mail.');
                    return redirect()->to('/login');
                }
            }
        }
    }

    public function logoff()
    {
        $session = session();

        $new_data = [

            'id' => null,
            'email' => null,
            'password' => null,
            'name' => null,
            'logged' => FALSE

        ];

        $session->set($new_data);
        $session->setFlashdata('msg', 'Deslogado com sucesso!');
        return redirect()->to('/login');

    }

}