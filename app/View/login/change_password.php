<div class="container">
    <?php $this->renderFeedbackMessages(); ?>

	<div class="login-page-box">
		<div class="table-wrapper">

			<!-- login box on left side -->
			<div class="login-box">
				<h2>Set new password</h2>
				<form method="post" action="/login/post_change_password" name="post_change_password">
					<label for="password_new">New password</label>
					<input id="password_new" type="password" name="password[new]" pattern=".{6,}" required autocomplete="off" placeholder="(min. 6 characters)" />

					<label for="password_repeat">Repeat password</label>
					<input id="password_repeat" type="password" name="password[repeat]" pattern=".{6,}" required autocomplete="off" />

					<input type="submit"  name="submit" value="Submit" />
				</form>

			</div>

			<!-- register box on right side -->
			<div class="register-box">
				<h2>Remember your password?</h2>
				<a class="follow" href="/login/index">Login</a>
			</div>

		</div>
	</div>






<!--    <div class="box">-->
<!--        <h2>Set new password</h2>-->
<!---->
<!--        <!-- new password form box -->
<!--        <form method="post" action="/login/post_change_password" name="post_change_password">-->
<!--            <label for="password_new">New password (min. 6 characters)</label>-->
<!--            <input id="password_new" type="password" name="password[new]" pattern=".{6,}" required autocomplete="off" />-->
<!---->
<!--            <label for="password_repeat">Repeat new password</label>-->
<!--            <input id="password_repeat" type="password" name="password[repeat]" pattern=".{6,}" required autocomplete="off" />-->
<!---->
<!--            <input type="submit"  name="submit" value="Submit" />-->
<!--        </form>-->
<!---->
<!--        <a class="follow" href="/login/index">Back to Login</a>-->
<!--    </div>-->
</div>
