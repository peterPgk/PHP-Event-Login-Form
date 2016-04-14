<div class="container">
    <?php
    use Pgk\Core\Auth;

    $this->renderFeedbackMessages(); ?>

    <div class="login-page-box">
        <div class="table-wrapper">

            <!-- login box on left side -->
            <div class="login-box">
                <h2>Login</h2>
                <form action="/login/login" method="post">
                    <input type="text" name="user[name]" placeholder="Username or email" required />
                    <input type="password" name="user[password]" placeholder="Password" required />
					<input type="hidden" name="csrf_token" value="<?= Auth::makeToken(); ?>" />
                    <input type="submit" class="login-submit-button" value="Log in"/>
                </form>
                <div class="link-forgot-my-password">
                    <a class="follow" href="/login/reset">Forget your password</a>
                </div>
            </div>

            <!-- register box on right side -->
            <div class="register-box">
                <h2>No account?</h2>
                <a class="follow" href="/register/index">Register</a>
            </div>

        </div>
    </div>
</div>
