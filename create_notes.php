<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Create Note';
include('includes/header.html');

// Check for form submission:.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('./pdo_connect.php'); // Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for a title:
	if (empty($_POST['title'])) {
		$errors[] = 'You forgot to enter the Title.';
	} else {
        // Old way to prevent SQL injection attacks
		//$fn = mysqli_real_escape_string($dbc, trim($_POST['title']));
		$ti = trim($_POST['title']);
	}

	// Check for a bodyNote:
	if (empty($_POST['bodyNote'])) {
		$errors[] = 'You forgot to enter the Body Note.';
	} else {
		$bn = trim($_POST['bodyNote']);
	}

	if (empty($errors)) { // If everything's OK.

		// Create the note in the database...
		
		$flag=TRUE;
		try {
			$q = "INSERT INTO notes (title, bodyNote, registration_date) VALUES (:ti, :bn, NOW() )";
			
			// 1. Preparamos la query a través del método "prepare" del OBJETO $pdo. (Devuelve un statement)
			$stmnt = $pdo->prepare($q);
			
			// 2. Substituir las etiquetas de la query por los valores introducidos en el formulario.
			// Se hace así porque si el usuario nos intenta hacer inyeccion de codigo, todo esto queda desactivado.
			$stmnt->bindValue(':ti',$ti);
			$stmnt->bindValue(':bn',$bn);

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
					<h1>--- Note created succesfully! ---</h1>
				  </div>';

		} else { // If it did not run OK.

			// Public message:
			echo '<div class=registered>
					<h1>--- System Error ---</h1>
					<p>Note not created</p>
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
?>
<section class="form-register">
	<h4>New Note</h4>
	<form action="create_notes.php" method="post">
		<!-- Sticky -->
		<input class="controls" type="text" name="title" size="15" maxlength="20" placeholder="Name..." value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
		<textarea class="controls textArea" name="bodyNote" cols="20" rows="3" placeholder="Enter the text..." value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></textarea>
		<input class="botons" type="submit" name="submit" value="Create Note">
	</form>
</section>
<?php include('includes/footer.html'); ?>