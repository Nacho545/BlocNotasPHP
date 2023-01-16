<?php # Script 9.7 - password.php
// This page lets a user change their password.

$page_title = 'Change Your Password';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('./pdo_connect.php'); // Connect to the db.

	$errors = []; // Initialize an error array.

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = trim($_POST['email']);
	}

	// Check for the current password:
	if (empty($_POST['pass'])) {
		$errors[] = 'You forgot to enter your current password.';
	} else {
		$p = trim($_POST['pass']);
	}

	// Check for a new password and match
	// against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = trim($_POST['pass1']);
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}

	if (empty($errors)) { // If everything's OK.

		// Check that they've entered the right email address/password combination:
		//$q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA2('$p', 512) )";

		// 1. Hacemos Select para comprobar que ese usuario existe.
	    $q = "SELECT user_id FROM users WHERE (email=:e AND pass=SHA2(:p, 512) )";
	    $stmnt = $pdo->prepare($q);
        
        $stmnt->bindValue(':e',$e);
        $stmnt->bindValue(':p',$p);
        $stmnt->execute();
        $rows=$stmnt->fetchAll();

		// 2. Si num es igual a 1 significa que existe y por tanto, podemos hacer
		// el UPDATE.
		$num = count($rows);
		if ($num == 1) { // Match was made.
            //exit ("Stop here to debug");

			// Get the user_id:
			//print_r($rows);
			//echo "<br>\n";
			$row = $rows[0];
            $id = $row['user_id'];
            //echo "id: $id";


            try {
				// Make the UPDATE query:
				//$q = "UPDATE users SET pass=SHA2('$np', 512) WHERE user_id=$row[0]";
				$q = "UPDATE users SET pass=SHA2(:np, 512) WHERE user_id=:id";
				
				$stmnt = $pdo->prepare($q);

				$stmnt->bindValue(':id',$id);
				$stmnt->bindValue(':np',$np);
	            $stmnt->execute();
            } catch (PDOException $e) {
            	$output = 'Database error: ' . $e->getMessage() . ' in ' .$e->getFile() . ':' . $e->getLine();
            }
            //echo 'rowCount: '.$stmnt->rowCount()."<br>\n";

			if ($stmnt->rowCount() == 1) { // If it ran OK.

				// Print a message.
				echo '<h1>Thank you!</h1>
				<p>Your password has been updated. In Chapter 12 you will actually be able to log in!</p><p><br></p>';

			} else { // If it did not run OK.

				// Public message:
				echo '<h1>System Error</h1>
				<p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';

				// Debugging message:
				echo '<p>' . $output . '<br><br>Query: ' . $q . '</p>';
			}


			// Include the footer and quit the script (to not show the form).
			include('includes/footer.html');
			exit();

		} else { // Invalid email address/password combination.
			echo '<h1>Error!</h1>
			<p class="error">The email address and password do not match those on file.</p>';
		}

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
<h1>Change Your Password</h1>
<form action="password.php" method="post">
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>Current Password: <input type="password" name="pass" size="10" maxlength="20" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" ></p>
	<p>New Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	<p>Confirm New Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p><input type="submit" name="submit" value="Change Password"></p>
</form>
<?php include('includes/footer.html'); ?>