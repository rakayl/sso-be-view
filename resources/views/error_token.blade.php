<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="display: flex;justify-content: center;align-items: center;height: 100vh;text-align: center">Token not found<br>Please add csrf_token to your view</div>
	<input type="hidden" class="msg" value="{{ $msg }}">
	<script src="{{ env('STORAGE_URL_VIEW') }}{{ ('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
			var messages = $('.msg').val();
		    alert('Token not found \n Please add csrf_token to your view');
		});
	</script>
</body>
</html>