 
function loadNumber(url, id){
    console.log('loadLocationNumber');
    
    console.log('id='+id)
    console.log('url='+url)
    var box = $('#'+id);
    var baseUrl = 'http://e1695549.webdev.cmaisonneuve.qc.ca/flycar/accueiluser/';
    $.ajax({

        // Adresse à laquelle la requête est envoyée
        url: baseUrl + url,

        // Le délai maximun en millisecondes de traitement de la demande
        timeout: 4000,

        // La fonction à apeller si la requête aboutie
        success: function (data) {
            // Je charge les données dans box
            console.log(data);
            box.html(data);
        },

        // La fonction à appeler si la requête n'a pas abouti
        error: function() {
            // J'affiche un message d'erreur
            //box.html("Désolé, aucun résultat trouvé.");
            console.log('erreur')
        }

    });

}

setInterval(loadNumber, 3000, 'ajax', 'reservationsAdmin');
//setInterval(loadNumber, 3000, 'ajax', 'reservationsAdminTab');

setInterval(loadNumber, 3000, 'ajaxpayees', 'reservationspayees');
setInterval(loadNumber, 3000, 'ajaxreservations', 'reservations');
setInterval(loadNumber, 3000, 'ajaxtopay', 'reservationstopay');
setInterval(loadNumber, 3000, 'ajaxrequetes', 'requetes');

