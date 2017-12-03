<?php 
require_once 'header.php';
require_once 'panelUser.php';
?>

<div class="container px-0 div-messagerie">
<?php 
  if(empty($data['messages'])){
?>
  <h2 class="text-center mt-4 mb-5 ">Votre boite de messagerie est vide.</h2>
  <?php 
  }else{
    // var_dump($data['messages']);

 ?>
  <div class="row mt-4 mx-0">
    <div class="col-sm-4 col-lg-3 my-2">
      <div class="row mx-1 px-0">
          <ul class="row mx-0 w-100 mt-0 nav admin-second-nav">
            <li class="nav-item col-sm-6 col-lg-6 rounded-top border-bottom-0 px-0 <?php echo $data['recu'] ? 'flycar-active' : '' ?> ">
              <a class="nav-link text-center px-0 " href="<?=PATH.'messagerie'?>">Messages <br> Reçus</a>
              </li>
              <li class="nav-item col-sm-6 col-lg-6 rounded-top border-bottom-0 px-0 <?php echo $data['recu'] ? '' : 'flycar-active' ?>">
                <a class="nav-link text-center px-0 " href="<?=PATH.'messagerie/sent'?>">Messages <br> Envoyés</a>
              </li>
          </ul>

        </div>
      <div class="mx-1 container-liste-messagerie">
      <?php 
      $premier = 'active';
      foreach ($data['messages'] as $value) {
        $nonlue='';
        if(strlen($value['text_message'])>30){
          $position=30;
          $position_=strpos($value['text_message'], '____');
          if($position_){
            $position=$position_;
          }
          $shortText =substr($value['text_message'],0,$position);
          $shortText.=' ...';
        }else{
          $shortText=$value['text_message'];
        }
        if(strlen($value['sujet'])>50){
          $shortSujet =substr($value['sujet'],0,50);
          $shortSujet.=' ...';
        }else{
          $shortSujet=$value['sujet'];
        }
        $time = strtotime($value['ecrire']);
        $madate = date("d/m/y", $time);
        $value['ecrire']=date("d/m/y Ghi", $time);
        if(!$value['lire']){
          $nonlue='div-warning';
        }
       
      ?>
      
        <div id="<?=$value['id_message'] ?>" class="flex-column py-2 px-2 liste-messagerie <?=$nonlue ?> <?=$premier ?>">
          <div class="d-flex justify-content-between">
            <p class="font-weight-bold mb-0"><?=$value['prenom_user'] . ' '. $value['nom_user']  ?></p>
            <p class="mb-0"><small><?=$madate ?></small></p>
          </div>
          <div class="">
            <p class="mb-0 line"><?=$shortSujet ?></p>
          </div>
          <div class="">
            <p class="mb-0 line"><em><?=$shortText ?></em></p>
          </div>
          
        </div>
      <?php 
      $premier='';
      } ?>
      </div>
     
    </div>
    
    <div class="col-xs-7 col-sm-8 col-lg-9 my-2">
      <?php 
        foreach ($data['messages'] as $value) {
          $time = strtotime($value['ecrire']);
          $value['ecrire']=date("d/m/y \à G\hi", $time);
       ?>
      <div class="mx-1 message">
        <div class="row w-100 mx-0 py-2 ">
          <div class="col-sm-9 col-md-9">
            <div class="row">
              <div class="col-sm-6">
              <p id="nom"><i class="fa fa-user" aria-hidden="true"></i> <?=$value['prenom_user'] . ' '. $value['nom_user']  ?></p>
              </div>
              <div class="col-sm-6">
                <p id="date" class="mb-1"><i class="fa fa-clock-o" aria-hidden="true"></i> <?=$value['ecrire'] ?></p>
              </div>
              
            </div>

            <div class="row">
              <div class="col-sm-12 mb-1">
                <p id="sujet" class="mb-0"><i class="fa fa-commenting-o" aria-hidden="true"></i> <?=$value['sujet']?></p>
              </div>

            </div>
          </div>
          <div class="col-sm-12 col-md-3">
            <form action="<?=PATH?>" method="POST">

              <div class="d-flex flex-column">
                <?php 
                if(isset($_GET['action']) && $_GET['action']=='sent'){
                }else{


                ?>
                
                  <input type="hidden" name="login" id="login" value="<?=$value['login']?>">
                  <input type="hidden" name="id_message" id="id_message" value="<?=$value['id_message']?>">
                  <button type="submit" name="reponseMessage" class="btn btn-sm d-block" formaction="<?=PATH.'messagerie/ecrire' ?>">Répondre</button>
                  <button type="submit"  class="btn btn-sm btn-danger mt-2" formaction="<?=PATH.'messagerie/supprimer' ?>">Supprimer</button>
                  <?php 
                  } ?>
              </div>
            </form>

            
          </div>
          
        </div><!--row -->
        <div class="row mx-2 mt-1 text-justify">
          <p id="texte"><?php echo nl2br($value['text_message'])?></p>
        </div>
      </div>
      <?php 
        break;
        } ?>
    </div>
  </div>
<?php 
  } ?>
</div>
      
<?php
require_once 'footer.php';
?>