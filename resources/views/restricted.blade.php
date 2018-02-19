<!doctype html>
<html>
<head>
	<title>JWT Test Interface -- RESTRICTED AREA</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="jumbotron">
			@if (Auth::check())
			<h1 class="display-4">SUCCESS!</h1>
			<p class="lead">Welcome {{Auth::user()->toArray()['name']}}!</p>
			<hr class="my-4">
			<p>Your JSON Web Token:</p>

			<ul class="list-group">			
				<li class="list-group-item list-group-item-primary">{{$pieces['header'][0]}}</li>
				<li class="list-group-item list-group-item-primary">{{$pieces['header'][1]}}</li>
				<li class="list-group-item list-group-item-success">{{$pieces['payload'][0]}}</li>
				<li class="list-group-item list-group-item-success">{{$pieces['payload'][1]}}</li>
				<li class="list-group-item list-group-item-danger">{{$pieces['signature'][0]}}</li>
				<li class="list-group-item list-group-item-danger">{{$pieces['signature'][1]}}</li>
			</ul>

			@else
			<h1 class="display-4">FAILURE!</h1>
			<p class="lead">You are not logged in!</p>
			@endif
		</div>
		

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>