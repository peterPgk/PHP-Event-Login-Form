<div class="container">
    <?php use Pgk\Core\Request;

    $this->renderFeedbackMessages(); ?>

    <div class="login-box">
        <h2>Register a new account</h2>

        <!-- register form -->
        <form method="post" action="/register/register">
            <!-- the user name input field uses a HTML5 pattern check -->
            <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user[name]" placeholder="Username (letters/numbers, 2-64 chars)" value="<?=Request::post('user.name');?>" required />
            <input type="email" name="user[email]" placeholder="email address (a real address)" value="<?=Request::post('user.email');?>" required />
            <input type="email" name="user[email_repeat]" placeholder="repeat email address" value="<?=Request::post('user.email_repeat');?>" required />
            <input type="password" name="user[password]" pattern=".{6,}" placeholder="Password (6 characters at least)" required autocomplete="off" />
            <input type="password" name="user[password_repeat]" pattern=".{6,}" required placeholder="Repeat password" autocomplete="off" />

            <input type="submit" value="Register" />
        </form>
    </div>

	<div class="register-box">
		<h2>Have an account?</h2>
		<a class="follow" href="/login/index">Login</a>
	</div>
</div>
