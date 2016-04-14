<div class="container">

	<?php
	use Pgk\Core\Auth;
	use Pgk\Core\Config;

	$this->renderFeedbackMessages();

	?>
	<div class="container-header">
		<h1>Edit your username</h1>
		<div class="navigation-container">
		<?php require Config::get('template_path') . 'navigation.php'; ?>
		</div>
	</div>


	<div class="box">
        <h2>Change your username</h2>

        <form action="/user/post_edit_username" method="post">
            <label for="username_new" class="block">New username:</label>
	        <input id="username_new" type="text" name="username[new]" required />

	        <label for="username_new" class="block">Repeat New username:</label>
	        <input id="username_new" type="text" name="username[repeat]" required />

	        <label for="username_new" class="block">Type Your Password:</label>
	        <input id="username_new" type="password" name="username[password]" required />

			<!-- set CSRF token at the end of the form -->
			<input type="hidden" name="csrf_token" value="<?= Auth::makeToken(); ?>" />
            <input type="submit" value="Submit" />
        </form>
    </div>
</div>
