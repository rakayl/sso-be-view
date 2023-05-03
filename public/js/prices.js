$('.price').each(function() {
    var input = $(this).val();
    var input = input.replace(/[\D\s\._\-]+/g, "");
    input = input ? parseInt( input, 10 ) : 0;

    $(this).val( function() {
        return ( input === 0 ) ? "" : input.toLocaleString( "id" );
    });
});

$( ".price" ).on( "keyup", numberFormat);
function numberFormat(event){
    var selection = window.getSelection().toString();
    if ( selection !== '' ) {
        return;
    }

    if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
        return;
    }
    var $this = $( this );
    var input = $this.val();
    var input = input.replace(/[\D\s\._\-]+/g, "");
    input = input ? parseInt( input, 10 ) : 0;

    $this.val( function() {
        return ( input === 0 ) ? "" : input.toLocaleString( "id" );
    });
}

$( ".price" ).on( "blur", checkFormat);
function checkFormat(event){
    var data = $( this ).val().replace(/[($)\s\._\-]+/g, '');
    if(!$.isNumeric(data)){
        $( this ).val("");
    }
}
$('#form').submit(function() {
    $('.price').each(function() {
        var number = $( this ).val().replace(/[($)\s\._\-]+/g, '');
        $(this).val(number);
    });
});