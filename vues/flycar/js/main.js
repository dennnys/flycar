$(function() {
    
    // ANIMATION ON SCROLL INIT
    AOS.init({
        duration: 1000,
        easing: 'ease-in-sine',
        delay: 0
    });
    // FIN ANIMATION ON SCROLL

    /* Note etoile */
    var etoileClick = 0;
    $('#note').val(etoileClick); 

    $('#etoiles .fa').on('mouseenter', function() {
        pasColoreEtoiles(5);
        var nr = $(this).attr('nr');
        coloreEtoiles(nr);
    });

    $('#etoiles .fa').on('click', function() {
        etoileClick = $(this).attr('nr');
        $('#note').val(etoileClick);
    });

  $('#etoiles .fa').on('mouseleave', function() {
        var nr = $(this).attr('nr');
        pasColoreEtoiles(nr);
    });

    $('#etoiles').on('mouseleave', function() {
        pasColoreEtoiles(5);
        coloreEtoiles(etoileClick);
    });

    function coloreEtoiles(n) {
        $('#etoiles .fa').each(function(){
            if($(this).attr('nr') <= n) {
                $(this).removeClass( "fa-star-o" );
                $(this).addClass( "fa-star" );
            }
        });
    }

    function pasColoreEtoiles(n) {
        $('#etoiles .fa').each(function(){
            if($(this).attr('nr') <= n) {
                $(this).removeClass( "fa-star" );
                $(this).addClass( "fa-star-o" );
            }
        });
    }

    /* FIN Notte etoile */
   
    /* login */
    $('.login-entre').click(function() {
			$('.wrap-login').show();
		});

	$('.fa-times-circle').click(function() {
		$('.wrap-login').hide();
	})
    /* end login */

    // tooltip inialize
    $('[data-toggle="tooltip"]').tooltip();
    // end tooltip

    $('select[name="marque"]').on('change', function(){
        console.log('marque change');
        // console.log($(this).val());

        var adresse = 'http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/voitures/modelesparmarque/'+$(this).val();
         $.ajax({
            url : adresse,
            method: "POST",

            success: function(resultat, statut){
                console.log(resultat);
                var arrayResultat =jQuery.parseJSON(resultat);
                console.log(arrayResultat);
                var select = $('select[name="modele"]');
                select.empty();
                select.append('<option value="0">Sélectionnez..</option>');
                for (var i = 0; i < arrayResultat.length; i++) {
                select.append('<option value="'+arrayResultat[i].id_modele +'">'+arrayResultat[i].nom_modele+'</option>');

                }
                    
                

                
               




                
            },
            error: function(resultat, statut, erreur){
                console.log(resultat);
                console.log(statut);
                console.log(erreur);
            }
        });
    });

    // image input voiture multiple display
    var defaultDiv = '<div class="thumbnail-box mx-1 my-1 rounded " id=divLogoAuto><img active="true" id="imgVoiture" class="my-custom-thumbnail img-fluid rounded" src="http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/vues/flycar/images/car_shape.png" alt=""></div>';
    // console.log(defaultDiv);
    if(window.File && window.FileList && window.FileReader){
        $('#voitureImgInput').change(function(event) {
            var files = event.target.files; //FileList object
            console.log(files);
            var output = document.getElementById("result");

            for(var i = 0; i< files.length; i++){
                var file = files[i];
                console.log(file);
                //Only pics
                // if(!file.type.match('image'))
                if(file.type.match('image/jpeg')){
                    if(this.files[0].size < 100000){    
                  // continue;
                    $('p.warning-image').css('border', 'none');
                    var picReader = new FileReader();
                    picReader.addEventListener("load",function(event){
                        var picFile = event.target;
                        var div = document.createElement("div");
                        div.className='thumbnail-div text-center';
                        div.innerHTML = "<div class='thumbnail-box mx-1 my-1 rounded'> <img active='true' id='imgVoiture' class='my-custom-thumbnail img-fluid rounded' src='"+picFile.result+"' alt=''></div>";
                        output.insertBefore(div,null);
                              
                    });
                    //Read the image
                    var iconeAuto = document.getElementById('divLogoAuto');

                    iconeAuto.className+=' d-none';
                    $('#clear, #result').show();
                    picReader.readAsDataURL(file);
                    }else{
                        $('p.warning-image').css('border', '2px solid red');
                        $(this).val("");
                    }
                }else{
                    $('p.warning-image').css('border', '2px solid red');
                    
                    $(this).val("");
                }
            }                               
           
        });
    }else{
        console.log("Your browser does not support File API");
    }


   $('#voitureImgInput').on("click", function() {
        $('.thumbnail-box').remove();
        $('#result').html(defaultDiv);
        $(this).val("");
    });

    $('#clear').on("click", function() {
        console.log( $('.thumbnail-box'));
        $('.thumbnail-box').remove();
        $('#result').html(defaultDiv);
        $('#voitureImgInput').val("");
        $(this).hide();
    });


    // fin image input voiture multiple
    // CALENDRIER DYNAMIQUE
  
    if($('#nonDisponibilite').length){
        var indisponibilite =  JSON.parse($('#nonDisponibilite').val());
        console.log('allo');
        for (var i = 0; i < indisponibilite.length; i++) {
          indisponibilite[i].date_debut_louer = moment(new Date(indisponibilite[i].date_debut_louer)).add(4,'hours');
          indisponibilite[i].date_fin_louer = moment(new Date(indisponibilite[i].date_fin_louer)).add(4,'hours');
        }   
    }
      // console.log($('input[name="dateDebut"]').val());

    if($('input[name="dateDebut"]').val() && $('input[name="dateFin"]').val()){
        // console.log(test);
        startingDateHere = moment(new Date($('input[name="dateDebut"]').val())).add(4,'hours');
        endingateHere = moment(new Date($('input[name="dateFin"]').val())).add(4,'hours');
        console.log(endingateHere);
        
    }else{
        startingDateHere=moment();
        endingateHere=moment().add(1,'day');
    }
      
  // console.log(indisponibilite);
    $('#customclasses').daterangepicker({
        "locale": {
          "format": "DD-MM-YYYY",
          "separator": " au ",
          "applyLabel": "Confirmer",
          "cancelLabel": "Effacer",
          "fromLabel": "De",
          "toLabel": "à",
          "customRangeLabel": "Personalisé",
          "weekLabel": "S",
          "daysOfWeek": [
              "dim",
              "lun",
              "mar",
              "mer",
              "jeu",
              "ven",
              "sam"
          ],
          "monthNames": [
              "Janvier",
              "Février",
              "Mars",
              "Avril",
              "Mai",
              "Juin",
              "Juillet",
              "Août",
              "Septembre",
              "Octobre",
              "Novembre",
              "Decembre"
          ],
          "firstDay": 1
        },
        selectPastInvalidDate: false,
        autoUpdateInput: true,
        startDate:startingDateHere,
        endDate:endingateHere,
        minDate:moment(),
        maxDate: moment().add(1, 'years'),
        isInvalidDate: function(date) {
            if($('#nonDisponibilite').length){
                for (var i = 0; i < indisponibilite.length; i++) {
               
                    if(date.format('DD-MM-YYYY') ==  indisponibilite[i].date_debut_louer.format('DD-MM-YYYY'))
                      return true;
                  
                    if(date.format('DD-MM-YYYY') ==  indisponibilite[i].date_fin_louer.format('DD-MM-YYYY'))
                      return true;
                  
                    if(date.isAfter( indisponibilite[i].date_debut_louer) && date.isBefore( indisponibilite[i].date_fin_louer))
                      return true;
                }
            }
            
          return false;

        },
        customDateClassname: function(date) {
          if($('#nonDisponibilite').length){
            for (var i = 0; i < indisponibilite.length; i++) {
              // console.log(indisponibilite[i][0]);
                if(date.format('DD-MM-YYYY') == indisponibilite[i].date_debut_louer.format('DD-MM-YYYY'))
                  return 'turnoverin';

                if(date.format('DD-MM-YYYY') == indisponibilite[i].date_fin_louer.format('DD-MM-YYYY'))
                  return 'turnoverout';

                if(date.isAfter(indisponibilite[i].date_debut_louer) && date.isBefore(indisponibilite[i].date_fin_louer))
                  return 'booked';
                }     
            }
          return false;
          
        }
    }, function(start, end, label) {
        // console.log('test start ' + start);
        // console.log('test end ' + end);
        // console.log('test label ' + label)
        var dateDebut = new Date(start);
        var dateFin = new Date(end);
        var dateDebutString = dateDebut.getFullYear() + '-'
         + ('0' + (dateDebut.getMonth()+1)).slice(-2) + '-'
         + ('0' + (dateDebut.getDate())).slice(-2) ;
        var dateFinString = dateFin.getFullYear() + '-'
         + ('0' + (dateFin.getMonth()+1)).slice(-2) + '-'
         + ('0' + (dateFin.getDate())).slice(-2) ;
        console.log(dateDebutString);
        console.log(dateFinString);
        $('input[name="dateDebut"]').val(dateDebutString);
        $('input[name="dateFin"]').val(dateFinString);
        $('input#customclasses').val(dateDebutString+' au '+dateFinString);

          //modal
        $('#myModal').on('show.bs.modal', function (e) {
            if($('li.nav-item.connected').length){
                console.log($('li.nav-item.connected').length);
                var datedebut = moment(dateDebutString).format("DD MM YYYY");
                var datefin = moment(dateFinString).format("DD MM YYYY");

                var a = moment(dateFinString);
                var b = moment(dateDebutString);
                var diff = a.diff(b, 'days') // 1

                var prixtotal = prix*diff;
                $('#ddebut').html(dateDebutString);
                $('#dfin').html(dateFinString);
                $('#prix').html(prix);
                $('#diff').html(diff);
                $('#prixtotal').html(prixtotal);
            }else{
                // $('.wrap-login').show();
            }
        
           
        
        });

    });


      
    $('input#customclasses').on('change', function(){
         $('input[name="dateDebut"]').val();
         $('input[name="dateFin"]').val();

               
    });



    // FIN CALENDRIER DYNAMIQUE
   


    // slider filtre prix auto
    var prixMin = $('#prixMin');
    var prixMax = $('#prixMax');
     // SLIDER POUR FILTRE DU PRIX
      // S'IL Y A DES VALEURS, AFFICHER LES VALEURS ENTRÃ‰S PAR L'UTILISATEUR
    if(prixMin.val() != '' && prixMax.val() != ''){
        $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 500,
        values: [ prixMin.val(), prixMax.val() ],
        step: 5,
        slide: function( event, ui ) {
            
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        prixMin.val(ui.values[0]);
        prixMax.val(ui.values[1]);
          }
        });
        // SINON VALEUR PAR DEFAULT :
    }else{
        $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 500,
        values: [ 0, 500 ],
        step: 5,
        slide: function( event, ui ) {
            
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        prixMin.val(ui.values[0]);
        prixMax.val(ui.values[1]);
          }
        });
    }

    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );


    // fin slider filtre prix auto


    // affichage message de la messagerie
    $('div.liste-messagerie').on('click', function(){
        var div = $(this);

        console.log(window.location.pathname);
        var url = window.location.pathname;
        var pageSent = /sent/.test(url);
        console.log(pageSent);
        if(pageSent){
            var adresse = 'http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/messagerie/showsent/'+$(this).attr('id');

        }else{
        var adresse = 'http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/messagerie/show/'+$(this).attr('id');

        }
        


        // console.log(adresse);
        $.ajax({
            url : adresse,
            method: "POST",

            success: function(resultat, statut){
                var arrayResultat =jQuery.parseJSON(resultat);
                $('div.message').fadeOut(210);
                var nom = '<i class="fa fa-user" aria-hidden="true"></i> ' + arrayResultat[0]['prenom_user'] + ' ' + arrayResultat[0]['nom_user']
                $('p#nom').html(nom);
                var date = arrayResultat[0]['ecrire'].slice(0,16);
                var date= date.replace(':', 'h');
                var date=date.replace('-', '/');
                var date=date.replace('-', '/');
                var date=date.replace(' ', ' à ');


                console.log(date);
                
                var ecrire = '<i class="fa fa-clock-o" aria-hidden="true"></i> '+ date;
                $('p#date').html(ecrire);

                var sujet = '<i class="fa fa-commenting-o" aria-hidden="true"></i> '+ arrayResultat[0]['sujet'];
                $('p#sujet').html(sujet);
                $('p#texte').html(arrayResultat[0]['text_message'].replace(/\r?\n/g,'<br/>'));
                $('input#login').val(arrayResultat[0]['login']);
                $('input#id_message').val(arrayResultat[0]['id_message']);
                $('div.liste-messagerie').each(function(){
                    $(this).removeClass('active');
                })
                div.addClass('active');
                setTimeout(function(){
                    $('div.message').fadeIn(200);

                }, 200)




                
            },
            error: function(resultat, statut, erreur){
                console.log(resultat);
                console.log(statut);
                console.log(erreur);
            }
        });
        if(!pageSent){
            var adresse2 = 'http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/messagerie/lu/'+$(this).attr('id');
            var div = $(this);
            $.ajax({
                url : adresse2,
                method: "POST",

                success: function(resultat, statut){
                    // console.log(div);
                    // console.log(resultat);
                    div.removeClass('div-warning');
                    // console.log(statut);
                    
                },
                error: function(resultat, statut, erreur){
                    // console.log(resultat);
                    // console.log(statut);
                    // console.log(erreur);
                }
            });
        }
    });
            
        




    //fin affichage message messagerie

    // preview image formulaire 
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPlaceholder').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#userImg").change(function(){
        readURL(this);
    });
    // finpreview image formulaire 

    // Date search background boutton filtre
    $('#btnFiltre').on('click', function(){
        $('.filtreBtnSearch').toggleClass('filtreBtnBackgroundOpened');
        $('.filtreBtnSearch').toggleClass('filtreBtnBackgroundClosed');
    });

    // image thumbnail/carousel page voiture
    var listeImg = $('img.my-custom-thumbnail');
    $('img.my-custom-thumbnail').on('click', function(){
        // $('#main-image').attr('src', $(this).attr('src'));
        transitionImgCarousel($(this).attr('src'));
        listeImg.each(function(){
            $(this).removeClass('active');
        })
        $(this).addClass('active');
    });

    $('#flecheDroite').on('click', function(){
        var listeImg = $('img.my-custom-thumbnail');

        var index=-1;
        listeImg.each(function(i){
            if($(this).hasClass('active')){
                index = i;
            }
        });
        listeImg.eq(index).removeClass('active');
        index=index+1;
        
         if(listeImg.length<=index){
            index=0;
        }
        var src = listeImg.eq(index).attr('src');
        listeImg.eq(index).addClass('active');
        transitionImgCarousel(src);


    });

    $('#flecheGauche').on('click', function(){
        var listeImg = $('img.my-custom-thumbnail');

        var index=-1;
        listeImg.each(function(i){
            if($(this).hasClass('active')){
                index = i;
            }
        });
        listeImg.eq(index).removeClass('active');
        index=index-1;
         if(0>index){
            index=listeImg.length-1;
        }
        var src = listeImg.eq(index).attr('src');
        listeImg.eq(index).addClass('active');
        transitionImgCarousel(src);

    });

    function transitionImgCarousel(src){
        $('#main-image').fadeOut(410);
        setTimeout(function(){
            $('#main-image').attr('src', src).fadeIn(400);

        }, 400)


    }
    // FIN image carousel/thumbnail page voiture
    
    // UP
    // deplace automatique up
  
        //$('#upAction').hide();

    $(window).scroll(function() {
        if ($(this).scrollTop() > 700) {
            $('#upAction').fadeIn();
        } else {
            $('#upAction').fadeOut();
        }
    });

    $('#upAction').click(function(){
        $('body,html').animate({
            scrollTop:0
        }, 800);
        return false;
    });

    // FIN UP

    // Aler 
    $('.alert-danger').click(function(){
        $(this).hide();
    });
    
    $('.alert-success').click(function(){
        $(this).hide();
    });

    // end Aler 


});

//Maxime
//upload et preview de la photo de profil
//et du permis de conduire


    $('.datepicker').datepicker({
        dateFormat: 'yy/mm/dd',
        //startDate: '-3d',
        datesDisabled:["2017/09/11","09/11/2017"],
        disabledDates:["2017/09/11","09/11/2017"]
    });

    
   $("#ajoutauto").on("click",function(){
        $("#formauto").toggle("hide")
    ;});

    $("#ajoutcontact").on("click",function(){
        $("#formcontact").toggle("hide")
    ;});

    //photo
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                console.log("loader")
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
    

    $(".file-upload").on('change', function(){
        console.log("fileuploadchange")
        readURL(this);
    });
    
    $(".charger-image").on('click', function() {
        console.log("changeclick")
       $(".file-upload").click();
    });

    function readURLInOut(input,output) {
        if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                        $(output).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
        }
    }


