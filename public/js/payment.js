var key = 1;
var kelas = 1;

$('.payment').click(function() {
	var count = $('.payment-count').length+1;
	var listItem = '\
  	<div class="form-group payment-count">\
        <label class="col-md-3 control-label">Name</label>\
        <div class="col-md-6">\
            <input type="text" placeholder="Payment name" class="form-control" name="method_name[]" required><br>\
            <input type="hidden" name="id_method[]" value="0">\
                <div id="tutorTarget'+count+'"></div>\
                <button type="button" class="btn btn-sm btn-info tutor1" onclick="addTutor('+count+')">Add Tutorial</button>\
	            <div class="btn btn-danger btn-sm m-btn m-btn--icon m-btn--pill removeRepeater"> \
			        <span> \
			          Delete Payment \
			        </span> \
		      	</div> \
    	<div><br><hr style="border-top: 1px solid #e0d8d8;margin-left: -150px;margin-right: -150px;"></div>\
        </div>\
  	</div>';

	$('#methodTarget').append(listItem).fadeIn(3000);

	$("body").on('click', ".removeRepeater", function() {
	  	var mbok = $(this).parent().parent();
	  	mbok.remove();
	});
});

function addTutor(no) {
	var count = $('#tutorTarget'+no+' > div').length;
	var id = count/2;
	var result = id+1;

	var listTutor = '<div class="col-md-10 tutor'+result+''+no+'">\
        <input type="text" placeholder="Input tutorial" class="form-control" name="tutorial_'+no+'[]" required/> <br> </div>\
        <input type="hidden" name="id_tutorial_'+no+'[]" value="0">\
    <div class="col-md-2 tutor'+result+''+no+'"">\
        <a onclick="deleteTutor('+result+''+no+')" data-repeater-delete class="btn btn-danger">\
            <i class="fa fa-close"></i>\
        </a>\
    </div>';

	$('#tutorTarget'+no).append(listTutor).fadeIn(3000);
}

function deleteTutor(no) {
	$('.tutor'+no).remove();
}