

  $('#multicol-country').on('change', function(){
    var agenceID = $(this).val();
    $('#agence').empty();
    $('#agence').append(`<option value="0" disabled>Chargement des agences en cours..</option>`);

    if(agenceID){
      $.ajax({
        type:'GET',
        url: `${baseUrl}auth/register-basic`,
        data:'id='+agenceID,
        success:function(res){

          $('#agence').empty();
          $('#agence').append(`<option value="0" disabled>Selectionnez l'agence</option>`);
          for( let i =0; i < res.length ; i++){
            $('#agence').append(`<option value="${res[i]['id']}">${res[i]['nom']}</option>`);
          }


        }
      });
    }

  });




