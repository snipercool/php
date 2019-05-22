<?php

    require_once 'bootstrap.php';

    if (!empty($_POST)) {
        $user = new User();
        $user->setFullname(htmlspecialchars($_POST['fullname']));
        $user->setUsername(htmlspecialchars($_POST['username']));
        $user->setEmail(htmlspecialchars($_POST['email']));
        $user->setPassword($_POST['password']);
        $user->setPasswordConfirmation($_POST['password_confirmation']);

        if ($user->isAccountAvailable($_POST['email']) && $user->isUsernameAvailable($_POST['username'])) {
            $data = $user->register();
            if ($data != false) {
                $_SESSION['user'] = $data;
                header('location: index.php');
            } else {
                $error = true;
            }
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>The Sockening</title>
  <link rel="stylesheet" href="dist/css/app.css">
</head>
<body>
	<div class="instaLogin instaLogin--register">
		<div class="form form--login">

			<form action="" method="post">
				<h2 form__title>Sign up for an account</h2>

        <?php if (isset($error)): ?>
					<div class="form__error">
						<p>
							<?php echo 'Something went wrong!'; ?>
							
						</p>
					</div>
        <?php endif; ?>

        <div class="form__field">
					<label for="fullname">Full name</label>
					<input type="text" id="fullname" name="fullname" required>
        </div>

				<div>
					<p class="availabilityCheck2"></p>
				</div>
                
        <div class="form__field">
					<label for="username">Username<span class="form__hint"></span></label>
					<input type="text" id="username" name="username" required>
        </div>
                
        <div>
					<p class="availabilityCheck"></p>
				</div>

				<div class="form__field">
					<label for="email">Email<span class="form__hint"></span></label>
					<input type="email" id="email" name="email" required> 
        </div>
                
				<div class="form__field">
					<label for="password">Password</label>
					<input type="password" id="password" name="password" required>
				</div>

        <div class="form__field">
					<label for="password_confirmation">Confirm your password</label>
					<input type="password" id="password_confirmation" name="password_confirmation" required>
				</div>

				<div class="form__field">
					<input type="submit" value="Sign me up!" class="btn btn--primary">	
        </div>
                
      </form>
            
		</div>
  </div>

  <script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
  <script language="JavaScript" type="text/javascript" src="js/check_email.js"></script>
  <script language="JavaScript" type="text/javascript" src="js/check_username.js"></script>


</body>
</html>