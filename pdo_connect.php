<?php
$flag=FALSE;
try {
    $pdo = new PDO('mysql:host=localhost;dbname=notepad;charset=utf8mb4', 'root', '');
    $output = 'Database connection established.';
} catch (PDOException $e) {
    // Al ser $e un objeto, tiene metodos.
    $output = 'Unable to connect to the database server: ' . $e->getMessage(). ' in ' .$e->getFile() . ':' . $e->getLine();
    $flag=TRUE;
}
if ($flag) die ("<p>$output</p>");
else echo "<p>$output</p>";
?>