<section class="form-register">
	<h4>Login</h4>
	<form action="login.php" method="post">
		<!-- Sticky -->
		<input class="controls" type="email" name="email" size="20" maxlength="60" placeholder="Email..." value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" >
		<input class="controls" type="password" name="pass1" size="10" maxlength="20" placeholder="Password..." value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" >
		<!-- <p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p> -->
		<input class="botons" type="submit" name="submit" value="Login">
	</form>
</section>