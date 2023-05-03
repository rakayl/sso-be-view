window.onload = function() {
    $('.serviceValue').prop('disabled', false);
    $('.serviceOperator').prop('disabled', true);
    $('.serviceKbuka').prop('disabled', true);
    $('.serviceKtutup').prop('disabled', true);

    $('.discountValue').prop('disabled', false);
    $('.discountOperator').prop('disabled', true);
    $('.discountKbuka').prop('disabled', true);
    $('.discountKtutup').prop('disabled', true);

    $('.taxValue').prop('disabled', false);
    $('.taxOperator').prop('disabled', true);
    $('.taxKbuka').prop('disabled', true);
    $('.taxKtutup').prop('disabled', true);

    $('.pointValue').prop('disabled', false);
    $('.pointOperator').prop('disabled', true);
    $('.pointKbuka').prop('disabled', true);
    $('.pointKtutup').prop('disabled', true);

    $('.cashbackValue').prop('disabled', false);
    $('.cashbackOperator').prop('disabled', true);
    $('.cashbackKbuka').prop('disabled', true);
    $('.cashbackKtutup').prop('disabled', true);

    checkServiceAwal();
    checkDiscountAwal();
    checkTaxAwal();
    checkPointAwal();
    checkCashbackAwal();
}

function checkServiceAwal() {
    var jumlah = checkServiceJumlah();

    if (jumlah < 1) {
        return false;
    } else {
        var checkShow = $("#targetService button:last")[0].id;
        part = checkShow.substring(6);
        console.log(part);

        if (part == 'subtotal' || part == 'service' || part == 'shipping' || part == 'discount' || part == 'tax') {
            var button = 'value';
        } else if (part == 'kali' || part == 'bagi' || part == 'tambah' || part == 'kurang') {
            var button = 'operator';
        } else if (part == '(') {
            var button = 'kbuka';
        } else {
            var button = 'ktutup';
        }
        // console.log(button);
        eval("clickservice" + button + "()");
    }
}

function setService(ev, key) {
    if (key == 'subtotal') {
        var text = 'Subtotal';
        var color = 'black';
    } 
    if (key == 'service') {
        var text = 'Service';
        var color = 'black';
    }
    if (key == 'discount') {
        var text = 'Discount';
        var color = 'black';
    }
    if (key == 'shipping') {
        var text = 'Shipping';
        var color = 'black';
    }
    if (key == 'tax') {
        var text = 'Tax';
        var color = 'black';
    }

    if (key == 'kali') {
        var text = '*';
        var color = 'blue';
    }
    if (key == 'bagi') {
        var text = '/';
        var color = 'blue';
    }
    if (key == 'tambah') {
        var text = '+';
        var color = 'blue';
    }
    if (key == 'kurang') {
        var text = '-';
        var color = 'blue';
    }
    if (key == 'kbuka') {
        var text = '(';
        var color = 'red';
    }
    if (key == 'ktutup') {
        var text = ')';
        var color = 'red';
    }

    $('#targetService').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.serviceValue').click(function() {
    clickservicevalue();
    $('.servicePersen').trigger('input');
});

$('.serviceOperator').click(function() {
    clickserviceoperator();
    $('.servicePersen').trigger('input');
});

$('.serviceKbuka').click(function() {
    clickservicekbuka();
    $('.servicePersen').trigger('input');
});

$('.serviceKtutup').click(function() {
    clickservicektutup();
    $('.servicePersen').trigger('input');
});

$('.serviceDelete').click(function() {
    var check = checkServiceJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetService > button:eq("+back+")")[0].id;
        part = hapus.split("result")[1];

        if (part == 'subtotal' || part == 'service' || part == 'shipping' || part == 'discount' || part == 'tax') {
            var button = 'value';
        } else if (part == 'kali' || part == 'bagi' || part == 'tambah' || part == 'kurang') {
            var button = 'operator';
        } else if (part == '(') {
            var button = 'kbuka';
        } else {
            var button = 'ktutup';
        }

        eval("clickservice" + button + "()");
    } else {
        clickserviceoperator();
    }

    $("#targetService > button").last().remove();
    $('.servicePersen').trigger('input');
});

function checkServiceJumlah() {
    var jlm = $("#targetService > button").length;
    return jlm;
}

function clickservicevalue() {
    var check = checkServiceJumlah();

    $('.serviceValue').prop('disabled', true);
    $('.serviceOperator').prop('disabled', false);
    $('.serviceKbuka').prop('disabled', true);

    if (check > 1) {
        $('.serviceKtutup').prop('disabled', false);
    } else {
        $('.serviceKtutup').prop('disabled', true);
    }
}

function clickserviceoperator() {
    $('.serviceOperator').prop('disabled', true);
    $('.serviceValue').prop('disabled', false);
    $('.serviceKbuka').prop('disabled', false);
    $('.serviceKtutup').prop('disabled', true);
}

function clickservicekbuka() {
    $('.serviceValue').prop('disabled', false);
    $('.serviceOperator').prop('disabled', true);
    $('.serviceKbuka').prop('disabled', true);
    $('.serviceKtutup').prop('disabled', true);
}

function clickservicektutup() {
    $('.serviceValue').prop('disabled', true);
    $('.serviceOperator').prop('disabled', false);
    $('.serviceKbuka').prop('disabled', true);
    $('.serviceKtutup').prop('disabled', true);
}

$('.servicePersen').on('input', function() {
    var item = [];
    var checkShow = $("#targetService button").length;
    var value = $(this).val();
    var testing = $("#targetService button");
    // console.log(testing);
    for (i = 0; i < checkShow; i++) {
        item.push(testing[i].id);
    }
    console.log(item);
    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'service',
            'value'   : value,
            'item': item,
        },
        success: function(data) {
            // console.log(data);
            if (data == 'success') {
                toastr.success('Service setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Service setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Service setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
});