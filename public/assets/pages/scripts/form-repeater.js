var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
        	$('.mt-repeater').each(function(){
                $(this).repeater({
        			show: function () {
	                	$(this).slideDown();
                        $('.date-picker').datepicker({
                            rtl: App.isRTL(),
                            orientation: "left",
                            autoclose: true
						});
						$('.tooltips').tooltip();
						$('.select2-container').remove();

                        if ($('body').hasClass('tagsinput')) {
                            $('.tagsinput').tagsinput();
                        }

		            },

		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
		                    $(this).slideUp(deleteElement);
		                }
		            },

		            ready: function (setIndexes) {

						$('.tooltips').tooltip()
		            }

        		});
        	});
        }

    };

}();

jQuery(document).ready(function() {
    FormRepeater.init();
});
