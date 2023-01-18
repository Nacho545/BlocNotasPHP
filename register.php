<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');

	echo '<div class=no-logged>
			<p>You are already logged in</p>
		  </div>';

} else {
    include('includes/header.html');

	// Check for form submission:.
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		require('./pdo_connect.php'); // Connect to the db.

		$errors = []; // Initialize an error array.

		// Check for a first name:
		if (empty($_POST['first_name'])) {
			$errors[] = 'You forgot to enter your first name.';
		} else {
			// Old way to prevent SQL injection attacks
			//$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
			$fn = trim($_POST['first_name']);
		}

		// Check for a last name:
		if (empty($_POST['last_name'])) {
			$errors[] = 'You forgot to enter your last name.';
		} else {
			$ln = trim($_POST['last_name']);
		}

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

		if (empty($errors)) { // If everything's OK.

			// Register the user in the database...
			
			$flag=TRUE;
			try {
				$p = hash("sha512", $p);
				$q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES (:fn, :ln, :e, :p, NOW() )";
				
				// 1. Preparamos la query a través del método "prepare" del OBJETO $pdo. (Devuelve un statement)
				$stmnt = $pdo->prepare($q);
				
				// 2. Substituir las etiquetas de la query por los valores introducidos en el formulario.
				// Se hace así porque si el usuario nos intenta hacer inyeccion de codigo, todo esto queda desactivado.
				$stmnt->bindValue(':fn',$fn);
				$stmnt->bindValue(':ln',$ln);
				$stmnt->bindValue(':e',$e);
				$stmnt->bindValue(':p',$p);

				// 3. Ejecutamos la query.
				$stmnt->execute();

			}
			catch (PDOException $e) {
				$output = 'Database error: ' . $e->getMessage() . ' in ' .$e->getFile() . ':' . $e->getLine();
				$flag=FALSE;
			}


			if ($flag) { // If it ran OK.

				// Print a message:
				echo '<div class=registered>
						<h1>--- Thank you! ---</h1>
						<p>You are now registered.</p>
					</div>';

			} else { // If it did not run OK.

				// Public message:
				echo '<div class=registered>
						<h1>--- System Error ---</h1>
						<p>You could not be registered due to a system error. We apologize for any inconvenience.</p>
					</div>';

				// Debugging message:
				echo $output;
				echo '<p>Query: ' . $q . '</p>';
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
	
	include('includes/register_include.php');
}
?>


<?php include('includes/footer.html'); ?>