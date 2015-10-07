var base_path = 'http://146.83.204.188';

$('#ins-mat-al').change(function(event) {
  event.preventDefault();
  var input = $(this);
  $.ajax({
    type: "POST",
    url: base_path+'/alumno/getInsInfoAlu',
    dataType: 'JSON',
    data: { matricula : input.val() },
    beforeSend: function( xhr ) {
      $('#loading-div').fadeIn();
      input.prop( "disabled", true );
    }
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
    console.log(jqXHR);
  })
  .done(function( res ) {
    if(res['resultado']){
      $('#info-alu-sol').html(res['widget']);
      $('#middle-container').html('');
      $('#right-container').html('');
    }else{
      $('#info-alu-sol').html('');
      $('#middle-container').html('');
      $('#right-container').html('');
    }
  })
  .always(function() {
    input.prop( "disabled", false );
    $('#loading-div').fadeOut();
  });
});

function errorAjax() {
  $('#loading-div').fadeOut();
  alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
}

function exitoAjax(response) {
  if(response.resultado){
    $('#loading-div').fadeOut();
    alertify.success(response.mensaje);
  }else{
    $('#loading-div').fadeOut();
    alertify.error('Ha Ocurrido un problema, inténtelo nuevamente.');
  }
}

$('#mod-crear-mod').click(function(event) {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: base_path+'/modulo/formNuevoModulo',
    dataType: 'JSON',
    beforeSend: function( xhr ) {
      $('#loading-div').fadeIn();
    }
  })
  .fail(function(jqXHR, textStatus, errorThrown) {
    console.log(jqXHR);
  })
  .done(function( res ) {
    if(res['resultado']){
      $('#middle-container').html(res['widget']);
    }else{
      $('#middle-container').html('');
    }
  })
  .always(function() {
    $('#loading-div').fadeOut();
  });
});
