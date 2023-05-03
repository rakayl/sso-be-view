var url = $('#url').val();

function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
    ev.preventDefault();
    var idFrom = ev.dataTransfer.getData('text');
    var idTo = ev.target.id;
    var empty = '<button type="button" id="empty'+idFrom+'" class="button-drag btn grey-cascade">Empty <i class="fa fa-question-circle tooltips" data-original-title="Value kosong yang tidak terpakai" data-container="body"></i></button>';
    var buttonFrom = document.getElementById(idFrom);
    var buttonTo = ev.target;
    var divFrom = document.getElementById(idFrom).parentElement;
    var divTo = ev.target.parentElement;

    // console.log(idFrom);
    // console.log(idTo);
    // console.log(buttonFrom);
    // console.log(buttonTo);
    // console.log(divFrom.id);
    // console.log(divTo);

    if (idTo == 'item1' || idTo == 'item2' || idTo == 'item3' || idTo == 'item4' || idTo == 'item5') {
        return false;
    }

    if (idTo != 'trash' || idTo == '') {
        $('#'+idTo).remove();
        $('#'+divTo.id).append(buttonFrom);
        
        if ((idTo != 'emptysubtotal' && idTo != 'emptyservice' && idTo != 'emptydiscount' && idTo != 'emptyshipping' && idTo != 'emptytax') || divFrom.id != 'trash') {
            $('#'+divFrom.id).append(buttonTo);
        }
    }

    if (idTo == 'trash') {
        $('#'+idTo).append(buttonFrom);
        $('#'+divFrom.id).append(empty);
    }

    var item1 = document.getElementById('item1').children[0].id;
    var item2 = document.getElementById('item2').children[0].id;
    var item3 = document.getElementById('item3').children[0].id;
    var item4 = document.getElementById('item4').children[0].id;
    var item5 = document.getElementById('item5').children[0].id;
    // console.log(item1);
    // console.log(item2);
    // console.log(item3);
    // console.log(item4);
    // console.log(item5);

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'grand_total',
            'item': [
                item1,item2,item3,item4,item5
            ]
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Grand total setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Grand total setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update grand total.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Grand total setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
}

$('.outlet').on('change', function() {
    var value = $(this).val();

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'outlet',
            'value'   : value,
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Outlet setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Outlet setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Outlet setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
});


