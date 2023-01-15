<?php # Script 10.1 - view_users.php #3
// This script retrieves all the records from the users table.
// This new version links to edit and delete pages.

$page_title = 'View the Current Notes';
include('includes/header.html');
echo '<div class=page-header>
    	<h1>----- Delete Notes -----</h1>
	  </div>';

require('./pdo_connect.php');

// Define the query:
$q = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC";
$result = $pdo->query($q);
// El metodo fetchAll() es para coger todos los datos.
// $rows es un ARRAY de ARRAYS.
$rows=$result->fetchAll();

// Count the number of returned rows:
$num = count($rows);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	
	echo '<div class=numNotes>
			<img src=images/logo.png alt=noteIcon>
			<p>There are currently '.$num.' registered users</p>
			<img src=images/logo.png alt=noteIcon>
	      </div>';
	// Table header:
	echo '<table width="60%">
	<thead>
	<tr>
		<th align="left"><strong>Edit</strong></th>
		<th align="left"><strong>Delete</strong></th>
		<th align="left"><strong>Last Name</strong></th>
		<th align="left"><strong>First Name</strong></th>
		<th align="left"><strong>Date Registered</strong></th>
	</tr>
	</thead>
	<tbody>
	';

	// Fetch and print all the records:
	//while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	foreach ($rows as $row) {
		// code...
		echo '<tr>
			<td align="left"><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>
			<td align="left"><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>
			<td align="left">' . $row['last_name'] . '</td>
			<td align="left">' . $row['first_name'] . '</td>
			<td align="left">' . $row['dr'] . '</td>
		</tr>
		';
	}

	echo '</tbody></table>';


} else { // If no records were returned.
	echo '<p class="error">There are currently no registered users.</p>';
}


include('includes/footer.html');
?>