function setCourier(ev, key) {
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

    $('#targetCourier').append( '<button style=" margin-left:7px; color: '+color+'" id="result'+key+'" type="button" class="button-drag btn btn-default">'+text+'</button>' );
}

$('.value').click(function() {
    clickvalue();
    count();
});

$('.operator').click(function() {
    clickoperator();
    count();
});

$('.kbuka').click(function() {
    clickkbuka();
    count();
});

$('.ktutup').click(function() {
    clickktutup();
    count();
});

$('.delete').click(function() {
    var check = checkJumlah();
    console.log(check);
    var back = check - 2;

    if (check > 1) {
        var hapus = $("#targetCourier > button:eq("+back+")")[0].id;
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

        eval("click" + button + "()");
    } else {
        clickoperator();
    }

    $("#targetCourier > button").last().remove();
    count();
});

function checkJumlah() {
    var jlm = $("#targetCourier > button").length;
    return jlm;
}

function clickvalue() {
    var check = checkJumlah();

    $('.value').prop('disabled', true);
    $('.operator').prop('disabled', false);
    $('.kbuka').prop('disabled', true);

    if (check > 1) {
        $('.ktutup').prop('disabled', false);
    } else {
        $('.ktutup').prop('disabled', true);
    }
}

function clickoperator() {
    $('.operator').prop('disabled', true);
    $('.value').prop('disabled', false);
    $('.kbuka').prop('disabled', false);
    $('.ktutup').prop('disabled', true);
}

function clickkbuka() {
    $('.value').prop('disabled', false);
    $('.operator').prop('disabled', true);
    $('.kbuka').prop('disabled', true);
    $('.ktutup').prop('disabled', true);
}

function clickktutup() {
    $('.value').prop('disabled', true);
    $('.operator').prop('disabled', false);
    $('.kbuka').prop('disabled', true);
    $('.ktutup').prop('disabled', true);
}

function count() {
    var item = [];
    var checkShow = $("#targetCourier button").length;
    // var value = $(this).val();
    var testing = $("#targetCourier button");
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
            'key'   : 'courier',
            // 'value'   : value,
            'item': item,
        },
        success: function(data) {
            console.log(data);
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
}