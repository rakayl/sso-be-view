function checkTaxAwal() {
    var jumlah = checkTaxJumlah();

    if (jumlah < 1) {
        return false;
    } else {
        var checkShow = $("#targetTax button:last")[0].id;
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
        eval("clicktax" + button + "()");
    }
}

function setTax(ev, key) {
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

    $('#targetTax').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.taxValue').click(function() {
    clicktaxvalue();
    $('.taxPersen').trigger('input');
});

$('.taxOperator').click(function() {
    clicktaxoperator();
    $('.taxPersen').trigger('input');
});

$('.taxKbuka').click(function() {
    clicktaxkbuka();
    $('.taxPersen').trigger('input');
});

$('.taxKtutup').click(function() {
    clicktaxktutup();
    $('.taxPersen').trigger('input');
});

$('.taxDelete').click(function() {
    var check = checkTaxJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetTax > button:eq("+back+")")[0].id;
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

        eval("clicktax" + button + "()");
    } else {
        clicktaxoperator();
    }

    $("#targetTax > button").last().remove();
    $('.taxPersen').trigger('input');
});

function checkTaxJumlah() {
    var jlm = $("#targetTax > button").length;
    return jlm;
}

function clicktaxvalue() {
    var check = checkTaxJumlah();

    $('.taxValue').prop('disabled', true);
    $('.taxOperator').prop('disabled', false);
    $('.taxKbuka').prop('disabled', true);

    if (check > 1) {
        $('.taxKtutup').prop('disabled', false);
    } else {
        $('.taxKtutup').prop('disabled', true);
    }
}

function clicktaxoperator() {
    $('.taxOperator').prop('disabled', true);
    $('.taxValue').prop('disabled', false);
    $('.taxKbuka').prop('disabled', false);
    $('.taxKtutup').prop('disabled', true);
}

function clicktaxkbuka() {
    $('.taxValue').prop('disabled', false);
    $('.taxOperator').prop('disabled', true);
    $('.taxKbuka').prop('disabled', true);
    $('.taxKtutup').prop('disabled', true);
}

function clicktaxktutup() {
    $('.taxValue').prop('disabled', true);
    $('.taxOperator').prop('disabled', false);
    $('.taxKbuka').prop('disabled', true);
    $('.taxKtutup').prop('disabled', true);
}

$('.taxPersen').on('input', function() {
    var item = [];
    var checkShow = $("#targetTax button").length;
    var value = $(this).val();
    var testing = $("#targetTax button");
    // console.log(testing);
    for (i = 0; i < checkShow; i++) {
        item.push(testing[i].id);
    }

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'tax',
            'value'   : value,
            'item': item,
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Tax setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Tax setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Tax setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
});