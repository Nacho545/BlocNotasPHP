<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Login';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

// Check for form submission:.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('./pdo_connect.php'); // Connect to the db.

    // 1. CHECK IF INPUTS ARE EMPTY.
	$errors = []; // Initialize an error array.

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = trim($_POST['email']);
	}

	// Check for a password:
	if (empty($_POST['pass1'])) {
        $errors[] = 'You forgot to enter your password.';
    } else {
        $p = trim($_POST['pass1']);			
    }

    
    // 2. CHECK IF ARRAY ERRORS IS EMPTY.
	if (empty($errors)) { // If everything's OK.

		// Login the user in the page...
		
		$flag=TRUE;
		try {

			$emailQuery = $_POST["email"];
			$passQuery = hash("sha512",$_POST["pass1"]);
            $q = "SELECT first_name, email, pass FROM users WHERE email=:email AND pass=:pass";
			
			// 1. Preparamos la query a través del método "prepare" del OBJETO $pdo. (Devuelve un statement)
			$stmnt = $pdo->prepare($q);
			
			// 2. Substituir las etiquetas de la query por los valores introducidos en el formulario.
			// Se hace así porque si el usuario nos intenta hacer inyeccion de codigo, todo esto queda desactivado.
			$stmnt->bindValue(':email',$emailQuery);
			$stmnt->bindValue(':pass',$passQuery);

			// 3. Ejecutamos la query.
			$stmnt->execute();


			// 4. Recuento de filas.
			$rows=$stmnt->fetchAll();

			// 5. Comprobamos si la longitud es 1. Entonces significará
			// que el usuario existe.
			if ($stmnt->rowCount() == 1) { // Valid user, show the message.
				echo '<div class=registered>
						<h1>--- Welcome! ---</h1>
						<p>You are now logued.</p>
		  			</div>';

			// Guardar datos de sesión
			$_SESSION["usuario"] = $_POST["email"];

			} else { // Not a valid user.
				echo '<div class=registered>
						<h1>--- No Registered ---</h1>
						<p>You could not be registered due to a system error</p>
						<p>We apologize for any inconvenience.</p>
		  			</div>';
			}
		}
		catch (PDOException $e) {
			$output = 'Database error: ' . $e->getMessage() . ' in ' .$e->getFile() . ':' . $e->getLine();
			$flag=FALSE;
		}

		// Include the footer and quit the script:
		include('includes/footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

} // End of the main Submit conditional.
?>
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
<?php include('includes/footer.html'); ?>