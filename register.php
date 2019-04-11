<?php

	require_once("classes/user.class.php");

	
	if ( !empty($_POST)) {
		$user = new User();
		$user->setEmail($_POST['email']);
		$user->setPassword($_POST['password']);
		$user->setPasswordConfirmation($_POST['password_confirmation']);
		if($user->register()) {
			session_start();
			$_SESSION['email'] = $user->getEmail();
 			header('location: index.php');
		}
		$error = true;

    }
    
   

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>The Sockening</title>
  <link rel="stylesheet" href="css/master.css">
</head>
<body>
	<div class="instaLogin instaLogin--register">
		<div class="form form--login">
			<form action="" method="post">
				<h2 form__title>Sign up for an account</h2>

                <?php if(isset($error)): ?>
				<div class="form__error">
					<p>
						<?php echo "Something went wrong!"; ?>
					</p>
				</div>
                <?php endif; ?>

				<div class="form__field">
					<label for="email">Email</label>
					<input type="text" id="email" name="email">
				</div>
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password">
				</div>

                <div class="form__field">
					<label for="password_confirmation">Confirm your password</label>
					<input type="password" id="password_confirmation" name="password_confirmation">
				</div>

				<div class="form__field">
					<input type="submit" value="Sign me up!" class="btn btn--primary">	
				</div>
			</form>
		</div>
	</div>
</body>
</html>