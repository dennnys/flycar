<?php 
require_once 'header.php';
?>


<div class="container">
  <form method="post" action="<?=PATH.'messagerie/envoyer' ?>">
    <input type="hidden" name="id_user_destinataire" value="">
      <div class="form-group row mt-3">
        
          
          <label for="destinataire" class="col-2 col-form-label">Écrire à</label>
          <div class="col-5">
          <?php 
          if(isset($data['destinataire'])){

           ?>
               <input class="form-control disabled" disabled type="text" value="<?=$data['destinataire'][0]['prenom_user'] . ' ' . $data['destinataire'][0]['nom_user']?>" name="nomComplet">
    <?php }else if(isset($data['message'])){ ?>
            <input class="form-control disabled" disabled type="text" value="<?=$data['message'][0]['prenom_user'] . ' ' . $data['message'][0]['nom_user']?>" name="nomComplet">
    <?php } ?>
          </div>
      </div>
      

    <div class="form-group row">
      <label for="sujet" class="col-2 col-form-label">Sujet</label>
      <div class="col-10">
        <?php 
        if(isset($data['message'])){
          ?>
          <input type="hidden" name="destinataire" value="<?=$data['message'][0]['login'] ?>">
          <?php 

          if(preg_match('/^RE ?:/', $data['message'][0]['sujet'])){

        ?>
        <input class="form-control" type="text" required value="<?=$data['message'][0]['sujet'] ?>" name="sujet">
        <?php 
          }else{
        ?>
            <input class="form-control" type="text" required value="RE: <?=$data['message'][0]['sujet'] ?>" name="sujet">
        <?php 
          }
        }else{
        ?>
          <input class="form-control" type="text" required value="" name="sujet" placeholder="Votre Sujet..">
          <input type="hidden" name="destinataire" value="<?=$data['destinataire'][0]['login'] ?>">
        <?php 
        }
        ?>

      </div>
    </div>
    <div class="form-group row">
      <label for="message" class="col-2 col-form-label">Message</label>
      <div class="col-10">
        <?php 
          if(isset($data['message'])){
         ?>
        <textarea class="form-control" placeholder="Votre Message.." required rows="20" name="texte">&#13;&#10;&#13;&#10;________________________________________________________&#13;&#10;<?=$data['message'][0]['text_message'] ?>
        </textarea>
        <?php 
        }else{

         ?>
         <textarea class="form-control" placeholder="Votre Message.." required rows="20" name="texte"></textarea>
        <?php 
        }
        ?>
        
      </div>
    </div>
    <div class="text-center mb-3">
      <button class="btn" type="submit" name="message">Envoyer</button>
    </div>
    
  </form>
</div>
<?php
require_once 'footer.php';
?>