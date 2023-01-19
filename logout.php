<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Logout';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

session_destroy();
echo '<div class=registered>
		<h1>--- See you soon! ---</h1>
		<p>You are now loged out.</p>
	</div>';
?>

<?php include('includes/footer.html'); 

header("Location: index.php");
exit
?>
