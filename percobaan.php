<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="jquery-ui/jquery-ui.js"></script>
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>
</head>
<body>
<form>
	<input type="text" name="angka1" id="angka1">
	<input type="text" name="angka1" id="angka2">
	<input type="text" name="hasil" id="hasil">
</form>
</body>
</html>
<script type="text/javascript">
	$("#angka1").keyup(function() {
		// body...
		var angka1 = $("#angka1").val();
		var angka2 = $("#angka2").val();

		var hasil = angka1 + angka2;

		$("#hasil").val(hasil);
	});
</script>