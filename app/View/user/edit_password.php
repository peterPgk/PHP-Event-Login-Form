<div class="container">
	<?php use Pgk\Core\Config;

	$this->renderFeedbackMessages();
	?>

	<div class="container-header">
		<h1>Edit your password</h1>
		<div class="navigation-container">
			<?php require Config::get('template_path') . 'navigation.php'; ?>
		</div>
	</div>

    <div class="box">
        <h2>Set new password</h2>

        <!-- new password form box -->
        <form method="post" action="/user/post_edit_password" name="new_password_form">
            <label class="block" for="password">Type Your Current Password:</label>
            <input id="password" type='password' name='password[password]' pattern=".{6,}" required autocomplete="off"  />

            <label class="block" for="password_new">New password (min. 6 characters)</label>
            <input id="password_new" type="password" name="password[new]" pattern=".{6,}" required autocomplete="off" />

            <label class="block" for="password_repeat">Repeat new password</label>
            <input id="password_repeat" type="password" name="password[repeat]" pattern=".{6,}" required autocomplete="off" />

            <input type="submit" class="login-submit-button" name="submit_new_password" value="Submit" />
        </form>

    </div>
</div>
