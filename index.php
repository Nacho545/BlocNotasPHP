<?php # Script 3.7 - index.php #2

$page_title = 'Notepad';

// Continuamos la sesión
session_start();
// Devolver los valores de sesión
if (isset($_SESSION["usuario"])){
    include('includes/header_logged.html');
} else {
    include('includes/header.html');
}

?>

<div class="page-header">
    <h1>----- Home -----</h1>
    <div>
        <p>This is where the page-specific content goes. This section, and the corresponding header, will change from one page to the next.</p>
        <p>Volutpat at varius sed sollicitudin et, arcu. Vivamus viverra. Nullam turpis. Vestibulum sed etiam. Lorem ipsum sit amet dolore. Nulla 
        facilisi. Sed tortor. Aenean felis. Quisque eros. Cras lobortis commodo metus. Vestibulum vel purus. In eget odio in sapien adipiscing blandit.
        Quisque augue tortor, facilisis sit amet, aliquam, suscipit vitae, cursus sed, arcu lorem ipsum dolor sit amet.</p>
    </div>
</div>

<?php

include('includes/footer.html');
?>