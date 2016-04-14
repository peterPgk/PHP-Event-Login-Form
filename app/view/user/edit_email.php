<div class="container">

	<?php use Pgk\Core\Config;

	$this->renderFeedbackMessages();
	?>

	<div class="container-header">
		<h1>Edit your email address</h1>
		<div class="navigation-container">
			<?php require Config::get('template_path') . 'navigation.php'; ?>
		</div>
	</div>


    <div class="box">
        <h2>Change your email address</h2>

        <form action="/user/post_edit_email" method="post">
            <label for="email" class="block">New email address: </label>
	        <input id="email" type="text" name="email[new]" required />
	        <label for="email_repeat" class="block">Repeat new email address: </label>
	        <input id="email_repeat" type="text" name="email[repeat]" required />
	        <label for="password" class="block">Type your password: </label>
	        <input id="password" type="password" name="email[password]" required />
            <input type="submit" value="Submit" />
        </form>
    </div>
</div>
