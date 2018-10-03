<!DOCTYPE HTML>
<!--
	Aesthetic by gettemplates.co
	Twitter: http://twitter.com/gettemplateco
	URL: http://gettemplates.co
-->
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Asoyaracuy</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Organizacion vecinal de la calle Yaracuy" />
	<meta name="keywords" content="organizacion, cuotas, yaracuy, asoyaracuy, vecinos, condominios" />
	<meta name="author" content="Cyberia Labtech" />

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">

	<!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- Bootstrap  -->
	{!!Html::style('/frontend/css/bootstrap.min.css')!!}

	<!-- NEW TEMPLATE -->
	{!!Html::style('/frontend/css/fontawesome.min.css')!!}
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!-- Coming Soon -->
	{!!Html::style('/frontend/css/coming-soon.min.css')!!}

	</head>
	<body>

		@yield('content')

    <!-- NEW TEMPLATE -->

	<!-- JQuery-->
    {!!Html::script('/frontend/js/jquery.min.js')!!}

    <!--JQuery Dropotron -->
    {!!Html::script('/frontend/js/coming-soon.min.js')!!}
	
	<!--Bootstrap Bundle -->
    {!!Html::script('/frontend/js/bootstrap-bundle.min.js')!!}
	</body>
</html>

