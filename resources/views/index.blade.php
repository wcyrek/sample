<!doctype html>
<html>
<head>
	<title>JWT Test Interface</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h1 class="display-4">Welcome to tiny JWT Middleware demo!</h1>
			<p class="lead">This is a very small code sample I provide to showcase some things I find interesting when it comes to Web Development.</p>
			<hr class="my-4">
			<p>JSON Web Tokens (JWT) are one way to authenticate users so they may interact with APIs in a stateless fashion. <a class="" href="https://jwt.io/introduction/" role="button">Learn more</a></p>
			
			<p class="lead">For purposes of this demo, I have seeded the database with 10 users as seen below. This page also generated a JWT for each user. By clicking the link below, you will be taken to restricted area of the site, with the token attached as a parameter.  The request should be intercepted by Middleware, which will authenticate you as the user for this one API call only. </p>
			<p><strong>Note:</strong> these tokens are only valid for 60 minutes, once expired you have to refresh this page to get fresh tokens.</p>
			<ul class="list-group">
				@foreach ($users as $user)
					<a href="/restricted?token={{$user['token']}}" class="list-group-item list-group-item-action">id: {{$user['id']}}, name: {{$user['name']}}</a>
				@endforeach
				<a href="/restricted" class="list-group-item list-group-item-action">Visit Sans Token</a>
			</ul>
		</div>
		

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>