<!DOCTYPE html>
<html> 
<head></head>
<body>
<table width="600" cellspacing="0" cellpadding="0" bgcolor="#fff" align="center">

	@include('templates.admin.email.header')

	@yield('content')
	
	@include('templates.admin.email.footer')	

</table>
</body>
</html>