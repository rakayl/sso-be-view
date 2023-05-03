<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	{{ csrf_field() }}
	Data Not Found
	<script src="{{ env('STORAGE_URL_VIEW') }}{{('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$( document ).ready(function() {
			var messages = 'Data not found';
		    alert(messages);
		});
	</script>
</body>
</html>