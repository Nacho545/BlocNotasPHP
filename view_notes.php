<?php # Script 10.1 - view_users.php #3
// This script retrieves all the records from the users table.
// This new version links to edit and delete pages.

$page_title = 'View Notes';
include('includes/header.html');
echo '<div class=page-header>
    	<h1>----- Notes -----</h1>
	  </div>';


echo '<div class=all_Notes>
			<div class=card>
				<h3 class=card__title>Nota 1</h3>
				<p class=card__content>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
				<div class=card__date>
					April 15, 2022
				</div>
				<div class=card__arrow>
					<svg xmlns=http://www.w3.org/2000/svg fill=none viewBox=0 0 24 24 height=15 width=15>
						<path fill=#fff d=M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z></path>
					</svg>
				</div>
			</div>

			<div class=card>
				<h3 class=card__title>Nota 2</h3>
				<p class=card__content>Lorem ipsum dolor sit amet consectetur adipisicing elit. </p>
				<div class=card__date>
					April 15, 2022
				</div>
				<div class=card__arrow>
					<svg xmlns=http://www.w3.org/2000/svg fill=none viewBox=0 0 24 24 height=15 width=15>
						<path fill=#fff d=M13.4697 17.9697C13.1768 18.2626 13.1768 18.7374 13.4697 19.0303C13.7626 19.3232 14.2374 19.3232 14.5303 19.0303L20.3232 13.2374C21.0066 12.554 21.0066 11.446 20.3232 10.7626L14.5303 4.96967C14.2374 4.67678 13.7626 4.67678 13.4697 4.96967C13.1768 5.26256 13.1768 5.73744 13.4697 6.03033L18.6893 11.25H4C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75H18.6893L13.4697 17.9697Z></path>
					</svg>
				</div>
			</div>
      </div>';


// require('./pdo_connect.php');

// // Define the query:
// $q = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC";
// $result = $pdo->query($q);

// // El metodo fetchAll() es para coger todos los datos.
// // $rows es un ARRAY de ARRAYS.
// $rows=$result->fetchAll();

// // Count the number of returned rows:
// $num = count($rows);

// if ($num > 0) { // If it ran OK, display the records.

// 	// Print how many users there are:
// 	echo "<p>There are currently $num registered users.</p>\n";

// 	// Table header:
// 	echo '<table width="60%">
// 	<thead>
// 	<tr>
// 		<th align="left"><strong>Edit</strong></th>
// 		<th align="left"><strong>Delete</strong></th>
// 		<th align="left"><strong>Last Name</strong></th>
// 		<th align="left"><strong>First Name</strong></th>
// 		<th align="left"><strong>Date Registered</strong></th>
// 	</tr>
// 	</thead>
// 	<tbody>
// 	';

// 	// Fetch and print all the records:
// 	//while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
// 	foreach ($rows as $row) {
// 		// code...
// 		echo '<tr>
// 			<td align="left"><a href="edit_user.php?id=' . $row['user_id'] . '">Edit</a></td>
// 			<td align="left"><a href="delete_user.php?id=' . $row['user_id'] . '">Delete</a></td>
// 			<td align="left">' . $row['last_name'] . '</td>
// 			<td align="left">' . $row['first_name'] . '</td>
// 			<td align="left">' . $row['dr'] . '</td>
// 		</tr>
// 		';
// 	}

// 	echo '</tbody></table>';


// } else { // If no records were returned.
// 	echo '<p class="error">There are currently no registered users.</p>';
// }


include('includes/footer.html');
?>