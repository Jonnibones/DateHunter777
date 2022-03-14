
<?php echo view('template/header'); ?>

    <span hidden id="msg_sweet"><?php foreach(session()->getFlashdata() as $msghidden){ echo $msghidden; } ?></span> 
        <!-- Error messages -->

        <?php if(session()->getFlashdata('msg')):?>
            <div id="div_msg" class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
        <?php endif;?>
    
    <div class="d-flex justify-content-center">
        <div class="card" style="width: 60rem; margin-top:50px; margin-bottom:20px; background-color:azure;">
        <div class="d-flex justify-content-center">
        <img style="max-width:200px;" class="card-img-top justify-content-center" src="http://localhost/datehunter777/images/logo-shark.png" alt="Card image cap">
        </div>
            <div class="card-body">
            <h1 class="card-title text-center">DateHunter</h1>
            <h1 class="text-center">Formulário de cadastro</h1>
                <!-- Form login -->
                <form action="register" method="post">

                    <div class="form-group">
                        <label>Nome: </label>

                        <input value="<?php if(isset($values['name_user'])){echo $values['name_user'];}?>" 
                        type="text" class="form-control"  name="name_user"  placeholder="Insira seu nome">

                        <?php if(isset($erros['name_user']) && $erros != '') : ?>
                        <small class="alert alert-danger"><?php echo $erros['name_user']; ?></small>
                        <?php endif ;?>

                    </div>

                    <div class="form-group">
                        <label>E-mail: </label>

                        <input value="<?php if(isset($values['email_user'])){echo $values['email_user'];}?>" 
                        type="email" class="form-control"  name="email_user"  placeholder="Insira seu melhor e-mail">

                        <?php if(isset($erros['email_user']) && $erros != '') : ?>
                        <small class="alert alert-danger"><?php echo $erros['email_user']; ?></small>
                        <?php endif ;?>

                    </div>

                    <div class="form-group">
                        <label>Senha</label>

                        <input value="<?php if(isset($values['pass_user'])){echo $values['pass_user'];}?>"
                        type="password" id="pass1" class="form-control" name="pass_user" placeholder="Crie uma senha">

                        <?php if(isset($erros['pass_user']) && $erros != '') : ?>
                        <small class="alert alert-danger"><?php echo $erros['pass_user']; ?></small>
                        <?php endif ;?>

                    </div>

                    <div class="form-group">
                        <label>Confirma senha</label>

                        <input id="pass2" value="<?php if(isset($values['conf_pass_user'])){echo $values['conf_pass_user'];}?>" 
                        type="password" class="form-control" name="conf_pass_user" placeholder="Repita sua senha">
                        <small id="small_pass2" class="alert alert-danger"></small> 
                        <div class="float-left"><a id="btn_show" class="btn btn-secondary" >Mostrar senha</a>  </div> 
                    </div>
                        <br>
                    <div class="row justify-content-center">
                        <button id="btn_cad" type="submit" name="btn_enter" class="btn btn-success btn-block ">Cadastrar</button>
                        <hr>
                        <a href="login" class="btn btn-primary btn-block  ">Voltar para a tela de login</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript" >

      window.onload = function() 
      {
        document.getElementById("small_pass2").style.visibility = "hidden";
      }

      var btn = document.getElementById("btn_cad");
      btn.addEventListener('click', confirmaSenha);
      
      function confirmaSenha(e)
      {
            var inputSenha1 = document.getElementById("pass1");
            var inputSenha2 = document.getElementById("pass2");
            var senha1 = inputSenha1.value;
            var senha2 = inputSenha2.value;
            if(senha1 != senha2)
            {
                e.preventDefault();
                var small = document.getElementById("small_pass2");
                small.style.visibility = "visible";
                small.innerText = "Senhas não podem ser diferentes.";

                setTimeout(function(){
                    var smallTimeOut = document.getElementById("small_pass2");
                    smallTimeOut.style.visibility = "hidden";
                }, 3000);
            }
       }
        
      var msg = document.getElementById('msg_sweet').textContent;
        if (msg == 'Cadastro efetuado com sucesso.') 
        {
            swal({
                icon: "success",
                text: "Cadastrado com sucesso!"
              });  
        }

        var msg = document.getElementById('msg_sweet').textContent;
        if (msg == 'Permissão negada.') 
        {
            swal({
                icon: "error",
                text: "Sem permissão para cadastro."
              });  
        }

        let btn_show = document.getElementById("btn_show");

        btn_show.addEventListener("click", function()
        {

            let input1 = document.getElementById('pass1');
            let input2 = document.getElementById('pass2');

            if(input1.getAttribute('type') == 'password' && input2.getAttribute('type') == 'password') 
            {
                input1.setAttribute('type', 'text');
                input2.setAttribute('type', 'text');
                btn_show.innerText = "Ocultar senha";
            }else 
            {
                input1.setAttribute('type', 'password');
                input2.setAttribute('type', 'password');
                btn_show.innerText = "Mostrar senha";
            }

        });


    </script>
    
    <?php echo view('template/footer'); ?>