<!doctype html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<title>Trans-Amigos Express: Label Maker</title>
		
		{!! Html::style( asset('css/all.css')) !!} 
		
	</head>

	<body>
		@include('nav')
		
		<div class="container">
			@yield('content')
		</div>
	</body>
	
	{!! Html::script( asset('js/app.js')) !!}
	
</html>