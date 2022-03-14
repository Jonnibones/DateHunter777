<?php echo view('template/header'); ?>

    <?php echo view('template/navtop'); ?>
      
    <div class="container container-class">
        <div class="row">
            
            <div style="padding: 10px;" class="col">
                <a id="btn_voltar" class="btn btn-primary btn-sm" href="<?php echo base_url('/dashboard');?>">Voltar</a>
            </div>

        </div>
    </div>
    
    <?php if(session()->getFlashdata('msg')):?>
        <div id="div_errors" class="alert alert-danger">    
            <?= session()->getFlashdata('msg') ?>
            <?php session_destroy(); ?>
        </div>
    <?php endif;?>

    <?php if (isset($errors)): ?>
        <div id="div_errors" class="container">
        <?php if(session()->getFlashdata('msg')):?>
            <div id="div_errors" class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
        <?php endif;?>
        <?php foreach ($errors as $error)
            {
                echo "<p class='alert alert-danger'>".$error."</p>";
            }
        ?>
        </div>
    <?php endif ; ?>

        <!-- Form insert product -->
    <div style="padding-bottom: 100px;" class="container" id="div_form_ins">

        <?php if (isset($msg)): ?>
            <?php echo "<span hidden id='msg_success'>".$msg."</span>"; ?>       
        <?php endif ; ?>

        <form id="form_ins_prod" method="post">

            <div id="div_titulo">
                <h1 class="text-center" id="titulo"><?php echo $h1; ?></h1>
            </div>

            <div style="margin: 10px;" class="form-group">
                <label for="exampleInputEmail1">Nome do produto</label>
                <input type="text" class="form-control" id="inp_name_prod" name="name_product" placeholder="Nome do produto" 
                value="<?php if (isset($inputs)){ echo $inputs[0]; } if (isset($dados_produto)) { echo $dados_produto['nome']; } ?>">
            </div>

            <div style="margin: 10px;" class="form-group">
                <label for="exampleInputPassword1">Data de Validade</label>
                <input type="date" class="form-control" id="inp_data_exp" name="date_exp_product" placeholder="Data de validade" 
                value="<?php if (isset($inputs)){ echo $inputs[1]; } if (isset($dados_produto)) { echo $dados_produto['date_exp']; } ?>">
            </div>

            <div style="margin: 10px;" class="form-group">
                <label for="exampleInputPassword1">Data de Notificação</label>
                <input type="date" class="form-control" id="inp_data_not" name="date_not_product" placeholder="Data de Notificação" 
                value="<?php if (isset($inputs)){ echo $inputs[2]; } if (isset($dados_produto)) { echo $dados_produto['date_not']; } ?>">
            </div>

            <div style="margin: 10px;" class="form-group">
                <label for="exampleInputPassword1">Observação</label>
                <input type="text" class="form-control" id="inp_obs" name="observ_product" placeholder="Observação" 
                value="<?php if (isset($inputs)){ echo $inputs[3]; } if (isset($dados_produto)) { echo $dados_produto['observ'];} ?>">
            </div>

            <input value="<?php session(); if(isset($_SESSION['id_user'])){echo $_SESSION['id_user'];}  ?>" type="hidden" class="form-control" id="inp_id" name="id_user" >
            <br>
            <div class="d-grid gap-2">
                <input class="btn btn-success btn-block" id="btn_env" type="submit" value="<?php echo $button; ?>">
            </div>
            
        </form>

    </div>
   
        
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script type="text/javascript" >

        var msg = document.getElementById('msg_success').textContent;
        if (msg == 'Inserido com sucesso!!') 
        {
            swal({
                icon: "success",
                text: "Inserido com sucesso!"
                });  
        }

    </script>

<?php echo view('template/footer'); ?>