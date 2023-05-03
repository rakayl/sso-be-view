function checkDiscountAwal() {
    var jumlah = checkDiscountJumlah();

    if (jumlah < 1) {
        return false;
    } else {
        var checkShow = $("#targetDiscount button:last")[0].id;
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
        eval("clickdiscount" + button + "()");
    }
}

$(document).on('keyup', '.discountPercent', function() {
    var checkNominal = $('.discountNominal').val();
    if (checkNominal != '0' && checkNominal !== '') {
        alert('if you want to fill in percent discount field, you have to empty the nominal discount');
        $(this).val('');
        $('.discountNominal').focus();
        return false;
    }
});

$(document).on('keyup', '.discountNominal', function() {
    var checkPer = $('.discountPercent').val();
    if (checkPer != '0' && checkPer !== '') {
        alert('if you want to fill in nominal discount field, you have to empty the percent discount');
        $(this).val('');
        $('.discountPercent').focus();
        return false;
    }
});

$(document).on('change', '.discountPercent', function() {
    count();
});

$(document).on('change', '.discountNominal', function() {
    count();
});

function setDiscount(ev, key) {
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

    $('#targetDiscount').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.discountValue').click(function() {
    clickdiscountvalue();
    count();
});

$('.discountOperator').click(function() {
    clickdiscountoperator();
    count();
});

$('.discountKbuka').click(function() {
    clickdiscountkbuka();
    count();
});

$('.discountKtutup').click(function() {
    clickdiscountktutup();
    count();
});

$('.discountDelete').click(function() {
    var check = checkDiscountJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetDiscount > button:eq("+back+")")[0].id;
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

        eval("clickdiscount" + button + "()");
    } else {
        clickdiscountoperator();
    }

    $("#targetDiscount > button").last().remove();
    count();
});

function checkDiscountJumlah() {
    var jlm = $("#targetDiscount > button").length;
    return jlm;
}

function clickdiscountvalue() {
    var check = checkDiscountJumlah();

    $('.discountValue').prop('disabled', true);
    $('.discountOperator').prop('disabled', false);
    $('.discountKbuka').prop('disabled', true);

    if (check > 1) {
        $('.discountKtutup').prop('disabled', false);
    } else {
        $('.discountKtutup').prop('disabled', true);
    }
}

function clickdiscountoperator() {
    $('.discountOperator').prop('disabled', true);
    $('.discountValue').prop('disabled', false);
    $('.discountKbuka').prop('disabled', false);
    $('.discountKtutup').prop('disabled', true);
}

function clickdiscountkbuka() {
    $('.discountValue').prop('disabled', false);
    $('.discountOperator').prop('disabled', true);
    $('.discountKbuka').prop('disabled', true);
    $('.discountKtutup').prop('disabled', true);
}

function clickdiscountktutup() {
    $('.discountValue').prop('disabled', true);
    $('.discountOperator').prop('disabled', false);
    $('.discountKbuka').prop('disabled', true);
    $('.discountKtutup').prop('disabled', true);
}

function count() {
    var item = [];
    var checkShow = $("#targetDiscount button").length;
    // var value = $(this).val();
    var testing = $("#targetDiscount button");
    var percent = $('.discountPercent').val();
    var nominal = $('.discountNominal').val();
    // console.log(testing);
    for (i = 0; i < checkShow; i++) {
        item.push(testing[i].id);
    }

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'discount',
            // 'value'   : value,
            'item': item,
            'percent': percent,
            'nominal': nominal,
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Discount setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Discount setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Discount setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
}