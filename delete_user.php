<?php # Script 10.2 - delete_user.php
// This page is for deleting a user record.
// This page is accessed through view_users.php.

$page_title = 'Delete a User';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

echo '<h1>Delete a User</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { // From view_users.php
	$id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
	$id = $_POST['id'];
} else { // No valid ID, kill the script.
	echo '<p class="error">This page has been accessed in error.</p>';
	include('includes/footer.html');
	exit();
}

require('./pdo_connect.php');

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['sure'] == 'Yes') { // Delete the record.

		// Make the query:
		//$q = "DELETE FROM users WHERE user_id=$id LIMIT 1";
        $q = "DELETE FROM users WHERE user_id=:id LIMIT 1";

        $statement = $pdo->prepare($q);
        $statement->bindValue(':id',$id);
        $statement->execute();


		if ($statement->rowCount() == 1) { // If it ran OK.

			// Print a message:
			echo '<p>The user has been deleted.</p>';

		} else { // If the query did not run OK.
			echo '<p class="error">The user could not be deleted due to a system error.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br>Query: ' . $q . '</p>'; // Debugging message.
		}

	} else { // No confirmation of deletion.
		echo '<p>The user has NOT been deleted.</p>';
	}

} else { // Show the form.

	//Comprobar que la SELECT devuelve algo, sino hacemos que salte error.
	// Retrieve the user's information:
	$q = "SELECT CONCAT(last_name, ', ', first_name) FROM users WHERE user_id=:id";
    $statement=$pdo->prepare($q);

    $statement->bindValue(':id',$id);
    $statement->execute();

    $rows=$statement->fetchAll();

	if ($statement->rowCount() == 1) { // Valid user ID, show the form.

		// Get the user's information:
		$row = $rows[0];

		// Display the record being deleted:
		echo "<h3>Name: $row[0]</h3>
		Are you sure you want to delete this user?";

		// Create the form:
		echo '<form action="delete_user.php" method="post">
	<input type="radio" name="sure" value="Yes"> Yes
	<input type="radio" name="sure" value="No" checked="checked"> No
	<input type="submit" name="submit" value="Submit">
	<input type="hidden" name="id" value="' . $id . '">
	</form>';

	} else { // Not a valid user ID.
		echo '<p class="error">This page has been accessed in error.</p>';
	}

} // End of the main submission conditional.


include('includes/footer.html');
?>
