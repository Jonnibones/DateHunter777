<?php echo view('template/header'); ?>

  <?php echo view('template/navtop'); ?>

      <span hidden id="msg_dash"><?php foreach(session()->getFlashdata() as $msg){ echo $msg; } ?></span>  

      <div class="container container-class">
        <div class="row">

          <div style="padding: 10px;" class="col">
            <h4 id="welcome" >Bem- <?php session(); echo $_SESSION['name_user'];?></h4>
          </div>

        </div>
      </div>

      <?php if (isset($products) && $products != null) : ?>

        <div style="margin-bottom: 20px;" class="row">
          <h5 class="text-center">Lista de produtos</h5>
        </div>

        <div id="div_list" class="container container-fluid" >
          
          <?php foreach($products as $product) : ?>

            <?php

              $alert ='';
              $dataAtual = strtotime(date('d-m-Y'));
              $dataVal = strtotime($product['date_exp_product']);

              $difference = $dataVal - $dataAtual;
              
              if (date('d-m-Y',$difference) <= 5 || intval(date('Y', $difference)) < 1970) 
              {
                $alert = 'danger';
              }
              elseif(date('d-m-Y',$difference) > 5 && date('d',$difference) <= 10) 
              {
                $alert = 'warning';
              }
              else
              {
                $alert = 'success';
              }
              
            ?>

            <div class="alert alert-<?php if(isset($alert)){ echo $alert; }?>">

                <h3>ID:</h3>
                <h6 id="list_id"><?php echo "<h6 id='cod_prod'>".$product['id'];?></h6>
                <hr>
                <h3>Nome do produto:</h3>
                <h4 id="list_name"><?php echo $product['name_product'];?></h4>
                <hr>
                <h3>Data de validade:</h3>
                <h4 id="list_date"><?php echo date_format(date_create($product['date_exp_product']), 'd-m-Y');?></h4>
                <hr>
                <h3>Observação:</h3>
                <h4 id="list_obs" ><?php if($product['observ_product'] != ''){ echo $product['observ_product'];} 
                else{ echo "Sem Observações."; } ?></h4>
                <hr>
                <h3>Ação:</h3>
                <a class="btn btn-warning " href="<?php echo base_url('/dashboard/editar/'.$product['id'])?>">Editar</a>
                <a class="btn btn-danger " onclick="return confirm('Tem certeza que deseja deletar este registro?')" href="<?php echo base_url('/dashboard/deletar/'.$product['id'])?>">Deletar</a>

            </div>
            
          <?php endforeach; ?>
        </div>

      <?php else : ?>

        <div style="width: 50%; margin-bottom:30px;" class="container container-fluid" id="div_btn_inserir" >
          <div class="d-grid gap-2">  
            <a class="btn btn-success btn-block" href="<?php echo base_url('/dashboard/inserir');?>">Inserir produtos</a>
          </div>
        </div>

        <div style="margin-top:20px" class="container">
          <figure>
              <img style="max-width:300px; margin-left:20px;" id="image_logo" src="http://localhost/datehunter777/images/astronaut.png" class="img-fluid" alt="astronaut">
          </figure>
          <h1 class="text-center">Sem produtos cadastrados.</h1>
        </div>
        

      <?php endif; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script type="text/javascript" >
        
      var msg = document.getElementById('msg_dash').textContent;
        if (msg == 'Atualizado com sucesso!!') 
        {
            swal({
                icon: "success",
                text: "Atualizado com sucesso!"
              });  
        }

        var msg = document.getElementById('msg_dash').textContent;
        if (msg == 'Registro Deletado com sucesso!!') 
        {
            swal({
                icon: "success",
                text: "Deletado com sucesso!"
              });  
        }

    </script>
    
<?php echo view('template/footer'); ?>
