<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href=" style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<title>Login</title>
</head>
<body class="bg-success bg-opacity-75 d-flex justify-content-center align-items-center vh-100">
	<div class="mx-5 py-5 card rounded login w-25 ">
		<div class="card-body">
			<form class="" method="POST" action="">
				<div class="d-flex flex-row justify-content-center">
					<div class="d-flex flex-column">
					<div class="mb-3" >
						<label class="form-label" for="username">Username</label>
						<input type="text" id="username" name="username" class="form-control">

					</div>
					<div class="mb-3" >
						<label class="form-label" for="password">Password</label>
						<input class="form-control" type="password" id="password" name="password">
					</div>
                    <div class="mb-3" >
						<label class="form-label" for="confirm_password">Confirm Password</label>
						<input class="form-control" type="password" name="confirm_password">
					</div>
                    <a href="login.php" class="mb-2"> Sudah Punya Akun ? Login Di Sini</a>
					<button class="btn btn-primary" type="submit">Register</button>
					</div>
				</div>
			</form>
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>