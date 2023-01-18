<?php # Script 10.1 - view_users.php #3
// This script retrieves all the records from the users table.
// This new version links to edit and delete pages.

$page_title = 'View Notes';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

echo '<div class=page-header>
    	<h1>----- Notes -----</h1>
	  </div>';
	  

require('./pdo_connect.php');

// Define the query:
$q = "SELECT title, bodyNote, DATE_FORMAT(registration_date_note, '%M %d, %Y') AS dr, userID FROM notes ORDER BY registration_date_note ASC";
$result = $pdo->query($q);

// El metodo fetchAll() es para coger todos los datos.
// $rows es un ARRAY de ARRAYS.
$rows=$result->fetchAll();

// Count the number of returned rows:
$num = count($rows);

if ($num > 0) { // If it ran OK, display the records.

	// Fetch and print all the records:
	//while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	echo '<div class=all_Notes>';
	foreach ($rows as $row) {
		// code...

		echo '<div class=card>
					<h3 class=card__title>'.$row["title"].'</h3>
					<p class=card__content>'.$row["bodyNote"].'</p>
					<div class=card__date>
						'.$row["dr"].'
					</div>
					<div class=card__arrow>
						<svg xmlns=http://www.w3.org/2000/svg fill=none viewBox=0 0 24 24 height=15 width=15>
							<path fill=#fff d=M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z></path>
						</svg>
					</div>
			   </div>';
      		  
	}
	echo '</div>';

} else { // If no records were returned.
	echo '<p class="error">There are currently no registered users.</p>';
}


include('includes/footer.html');
?>