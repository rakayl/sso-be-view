$( "#form" ).submit(function( event ) {
  $("#submit").attr("disabled", true);
  $("#submit").addClass("m-loader m-loader--light m-loader--right");
});

$( "#formWithPrice" ).submit(function() {
  $( "#submit" ).attr("disabled", true);
  $( "#submit" ).addClass("m-loader m-loader--light m-loader--right");
  $( ".price" ).each(function() {
	var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
	$(this).val(number);
  });

  $(".exchange").val($(".exchange").replace(',', '.'));
    
});

$( "#formWithPrice2" ).submit(function() {
  $( "#submit" ).attr("disabled", true);
  $( "#submit" ).addClass("m-loader m-loader--light m-loader--right");
  $( ".price" ).each(function() {
	var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
	$(this).val(number);
  });

  $(".exchange").val($(".exchange").replace(',', '.'));
    
});

$( ".price" ).on( "keyup", numberFormat);
$( ".price" ).on( "blur", checkFormat);

function checkFormat(event){
  var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
  if(!$.isNumeric(data)){
	$( this ).val("");
  }
}

function numberFormat(event){
  // When user select text in the document, also abort.
  var selection = window.getSelection().toString();
  if ( selection !== '' ) {
	  return;
  }
  // When the arrow keys are pressed, abort.
  if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
	  return;
  }
  var $this = $( this );
  // Get the value.
  var input = $this.val();
  var input = input.replace(/[\D\s\._\-]+/g, "");
  input = input ? parseInt( input, 10 ) : 0;

  $this.val( function() {
	  return ( input === 0 ) ? "" : input.toLocaleString( "id" );
  } );
}