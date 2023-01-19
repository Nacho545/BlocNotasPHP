<section class="form-register">
	<h4>New Note</h4>
	<form action="create_notes.php" method="post">
		<!-- Sticky -->
		<input class="controls" type="text" name="title" size="15" maxlength="20" placeholder="Name..." value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
		<textarea class="controls textArea" name="bodyNote" cols="20" rows="3" placeholder="Enter the text..." value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>"></textarea>
		<input class="botons" type="submit" name="submit" value="Create Note">
	</form>
</section>