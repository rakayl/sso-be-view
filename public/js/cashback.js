function checkCashbackAwal() {
    var jumlah = checkCashbackJumlah();

    if (jumlah < 1) {
        return false;
    } else {
        var checkShow = $("#targetCashback button:last")[0].id;
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
        eval("clickcashback" + button + "()");
    }
}

function setCashback(ev, key) {
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

    $('#targetCashback').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.cashbackValue').click(function() {
    clickcashbackvalue();
    $('.cashbackPersen').trigger('input');
});

$('.cashbackOperator').click(function() {
    clickcashbackoperator();
    $('.cashbackPersen').trigger('input');
});

$('.cashbackKbuka').click(function() {
    clickcashbackkbuka();
    $('.cashbackPersen').trigger('input');
});

$('.cashbackKtutup').click(function() {
    clickcashbackktutup();
    $('.cashbackPersen').trigger('input');
});

$('.cashbackDelete').click(function() {
    var check = checkCashbackJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetCashback > button:eq("+back+")")[0].id;
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

        eval("clickcashback" + button + "()");
    } else {
        clickcashbackoperator();
    }

    $("#targetCashback > button").last().remove();
    $('.cashbackPersen').trigger('input');
});

function checkCashbackJumlah() {
    var jlm = $("#targetCashback > button").length;
    return jlm;
}

function clickcashbackvalue() {
    var check = checkCashbackJumlah();

    $('.cashbackValue').prop('disabled', true);
    $('.cashbackOperator').prop('disabled', false);
    $('.cashbackKbuka').prop('disabled', true);

    if (check > 1) {
        $('.cashbackKtutup').prop('disabled', false);
    } else {
        $('.cashbackKtutup').prop('disabled', true);
    }
}

function clickcashbackoperator() {
    $('.cashbackOperator').prop('disabled', true);
    $('.cashbackValue').prop('disabled', false);
    $('.cashbackKbuka').prop('disabled', false);
    $('.cashbackKtutup').prop('disabled', true);
}

function clickcashbackkbuka() {
    $('.cashbackValue').prop('disabled', false);
    $('.cashbackOperator').prop('disabled', true);
    $('.cashbackKbuka').prop('disabled', true);
    $('.cashbackKtutup').prop('disabled', true);
}

function clickcashbackktutup() {
    $('.cashbackValue').prop('disabled', true);
    $('.cashbackOperator').prop('disabled', false);
    $('.cashbackKbuka').prop('disabled', true);
    $('.cashbackKtutup').prop('disabled', true);
}

$('.cashbackPersen').on('input', function() {
    var item = [];
    var checkShow = $("#targetCashback button").length;
    var value = $(this).val();
    var max = $('.cashbackMax').val();
    var testing = $("#targetCashback button");
    // console.log(testing);
    for (i = 0; i < checkShow; i++) {
        item.push(testing[i].id);
    }

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'cashback',
            'value'   : value,
            'max'   : max,
            'item': item,
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Cashback setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Cashback setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Cashback setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
});

$('.cashbackMax').on('input', function() {
    $('.cashbackPersen').trigger('input');
});