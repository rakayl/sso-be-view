function checkPointAwal() {
    var jumlah = checkPointJumlah();

    if (jumlah < 1) {
        return false;
    } else {
        var checkShow = $("#targetPoint button:last")[0].id;
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
        eval("clickpoint" + button + "()");
    }
}

function setPoint(ev, key) {
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

    $('#targetPoint').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.pointValue').click(function() {
    clickpointvalue();
    $('.pointPersen').trigger('input');
});

$('.pointOperator').click(function() {
    clickpointoperator();
    $('.pointPersen').trigger('input');
});

$('.pointKbuka').click(function() {
    clickpointkbuka();
    $('.pointPersen').trigger('input');
});

$('.pointKtutup').click(function() {
    clickpointktutup();
    $('.pointPersen').trigger('input');
});

$('.pointDelete').click(function() {
    var check = checkServiceJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetPoint > button:eq("+back+")")[0].id;
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

        eval("clickpoint" + button + "()");
    } else {
        clickpointoperator();
    }

    $("#targetPoint > button").last().remove();
    $('.pointPersen').trigger('input');
});

function checkPointJumlah() {
    var jlm = $("#targetPoint > button").length;
    return jlm;
}

function clickpointvalue() {
    var check = checkServiceJumlah();

    $('.pointValue').prop('disabled', true);
    $('.pointOperator').prop('disabled', false);
    $('.pointKbuka').prop('disabled', true);

    if (check > 1) {
        $('.pointKtutup').prop('disabled', false);
    } else {
        $('.pointKtutup').prop('disabled', true);
    }
}

function clickpointoperator() {
    $('.pointOperator').prop('disabled', true);
    $('.pointValue').prop('disabled', false);
    $('.pointKbuka').prop('disabled', false);
    $('.pointKtutup').prop('disabled', true);
}

function clickpointkbuka() {
    $('.pointValue').prop('disabled', false);
    $('.pointOperator').prop('disabled', true);
    $('.pointKbuka').prop('disabled', true);
    $('.pointKtutup').prop('disabled', true);
}

function clickpointktutup() {
    $('.pointValue').prop('disabled', true);
    $('.pointOperator').prop('disabled', false);
    $('.pointKbuka').prop('disabled', true);
    $('.pointKtutup').prop('disabled', true);
}

$('.pointPersen').on('input', function() {
    var item = [];
    var checkShow = $("#targetPoint button").length;
    var value = $(this).val();
    var testing = $("#targetPoint button");
    // console.log(testing);
    for (i = 0; i < checkShow; i++) {
        item.push(testing[i].id);
    }

    $.ajax({
        type: 'POST',
        url:  url,
        data: {
            '_token': $('input[name=_token]').val(),
            'key'   : 'point',
            'value'   : value,
            'item': item,
        },
        success: function(data) {
            console.log(data);
            if (data == 'success') {
                toastr.success('Point setting has beed updated.', 'Success Alert', {timeOut: 1000});
            } else if (data == 'failure') {
                toastr.error('Point setting update failed.', 'Error Alert', {timeOut: 1000});
            } else {
                toastr.error('Something went wrong. Failed to update setting.', 'Error Alert', {timeOut: 1000});
            }
        },
        error: function(data) {
            toastr.error('Point setting update failed.', 'Error Alert', {timeOut: 1000});
        }
    });
});