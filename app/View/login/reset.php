<div class="container">
    <?php $this->renderFeedbackMessages(); ?>

    <div class="login-box">
	    <div class="container-header">
		    <h2>Request a password</h2>
	    </div>
        <!-- request password reset form box -->
        <form method="post" action="/login/post_reset">
	        <label for="username" class="block">
		        Enter your username or email to get a mail with instructions:
	        </label>
            <input type="text" id="username" name="reset[username]" required />
            <input type="submit" value="Send" />
        </form>
    </div>

	<div class="register-box">
		<h2>Remember password?</h2>
		<a class="follow" href="/login/index">Login</a>
	</div>
</div>
