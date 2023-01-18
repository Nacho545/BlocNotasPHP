<?php # Script 10.3 - edit_note.php
// This page is for editing a note record.
// This page is accessed through view_notes.php.

$page_title = 'Edit a note';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');

	echo '<div class=page-header>
    	<h1>----- Edit a Note -----</h1>
	  </div>';


	// Check for a valid note ID, through GET or POST:
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_notes.php
		$id = $_GET['id'];
	} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
		$id = $_POST['id'];
	} else { // No valid ID, kill the script.
		echo '<div class=page-header>
				<p>Invalid ID</p>
			</div>';
		include('includes/footer.html');
		exit();
	}

	require('./pdo_connect.php');

	// Check if the form has been submitted:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$errors = [];

		// Check for a Title:
		if (empty($_POST['title'])) {
			$errors[] = 'You forgot to enter the Title.';
		} else {
			$ti = trim($_POST['title']);
		}

		// Check for a bodyNote:
		if (empty($_POST['bodyNote'])) {
			$errors[] = 'You forgot to enter the Body Note.';
		} else {
			$bn = trim($_POST['bodyNote']);
		}

		if (empty($errors)) { // If everything's OK.

			// Make the query:
			$q = "UPDATE notes SET title=:ti, bodyNote=:bn WHERE note_id=:id LIMIT 1";

			$statement=$pdo->prepare($q);

			$statement->bindValue(':ti',$ti);
			$statement->bindValue(':bn',$bn);
			$statement->bindValue(':id',$id);
			$statement->execute();

			if ($statement->rowCount() == 1) { // If it ran OK.

				// Print a message:
				echo '<div class=registered>
						<p>The note has been edited.</p>
					</div>';

			} else { // If it did not run OK.
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
			}
		}

	} // End of submit conditional.



	// Always show the form...

	// Retrieve the note information:
	$q = "SELECT title, bodyNote FROM notes WHERE note_id=:id";
	$statement=$pdo->prepare($q);

	$statement->bindValue(':id',$id);
	$statement->execute();
	$rows=$statement->fetchAll();


	if (count($rows) == 1) { // Valid note ID, show the form.

		// Get the note information:
		$row = $rows[0];

		// Create the form:
		echo '<section class="form-register">
				<form action="edit_user.php" method="post">
					<label>Title</label>
					<input class=controls type="text" name="title" size="15" maxlength="15" value="' . $row[0] . '">
					<label>Body Note</label>
					<input class=controls type="text" name="bodyNote" size="15" maxlength="30" value="' . $row[1] . '">
					<input class=botons type="submit" name="submit" value="Submit"></p>
					<input type="hidden" name="id" value="' . $id . '">
				</form>
			</section>';

	} else { // Not a valid note ID.
		echo '<div class=registered>
				<p>Invalid ID note</p>
			</div>';
	}

} else {
    include('includes/header.html');

	echo '<div class=no-logged>
			<p>Please, login first</p>
		  </div>'; 
}



include('includes/footer.html');
?>