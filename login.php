<?php
include_once 'bootstrap.php';
// get user and password from POST
if (!empty($_POST)) {
    $username = ($_POST['username']);
    $password = $_POST['password'];

    $user = new User();
    $user->setUsername($username);
    $user->setPassword($password);
    //check if user can login (use function)
    $data = $user->CanILogin();
    if ($data != false) {
        $_SESSION['user'] = $data;
        // if ok -> redirect to index.php
        header('Location: index.php');
    } else {
        $error = 'Login failed';
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TheSockening</title>
  <link rel="stylesheet" href="dist/css/app.css">
</head>
<body>
	<div class="Login">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign In</h2>

				<?php if (isset($error)): ?>
				<div class="form__error">
					<p>
						Sorry, we can't log you in with that username and password. Can you try again?
					</p>
				</div>
				<?php endif; ?>

				<div class="form__field">
					<label for="username">Username</label>
					<input type="text" id="username" name="username">
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign in" class="btn btn--primary">	
					<input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
				</div>
			</form>
		</div>
	</div>
</body>
</html>