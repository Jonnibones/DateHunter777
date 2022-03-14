
<?php echo view('template/header'); ?>

    <div>
        <!-- Error messages -->
        <?php if(session()->getFlashdata('msg')):?>
            <div id="div_msg" class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
        <?php endif;?>
    </div>
    
    <div class="d-flex justify-content-center">
        <div class="card" style="width: 60rem; margin-top:50px; margin-bottom:20px; background-color:azure;">

            <div class="d-flex justify-content-center">
                <img style="max-width:200px;" class="card-img-top justify-content-center" src="http://localhost/datehunter777/images/logo-shark.png" alt="Card image cap">
            </div>

            <div class="card-body">

                <h3 class="card-title text-center">DateHunter777</h3>
                <h3 class="text-center">Login</h3>

                <!-- Form login -->
                <form id="form_login" action="login/auth" method="post">

                    <div class="form-group">
                        <label>Endereço de e-mail</label>
                        <input type="email" class="form-control" name="inp_email" aria-describedby="emailHelp" placeholder="E-mail">
                        <small id="emailHelp" class="form-text text-muted">Jesus te ama.</small>
                    </div>

                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" class="form-control" id="inp_pass" name="inp_pass" placeholder="Senha">
                        <a id="btn_show_pass" class="btn btn-secondary btn-sm">Mostrar senha</a>
                    </div>
                        
                    <br>

                    <div class="row justify-content-center">
                        <button type="submit" name="btn_enter" class="btn btn-success btn-block">Entrar</button>
                    </div>
                    <hr>
                    <div class="row justify-content-center">
                        <a class="btn btn-primary btn-block" id="link_register" href="<?php echo base_url('/register');?>">Cadastre-se</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>

        let btn = document.getElementById("btn_show_pass");

        btn.addEventListener("click", function(){

            let input = document.getElementById('inp_pass');

            if(input.getAttribute('type') == 'password') 
            {
                input.setAttribute('type', 'text');
                btn.innerText = "Ocultar senha";
            }else 
            {
                input.setAttribute('type', 'password');
                btn.innerText = "Mostrar senha";
            }

        });
        
    </script>
    
    <?php echo view('template/footer'); ?></body>
