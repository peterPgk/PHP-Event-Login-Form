<?php

use Pgk\Core\Session;
?>
<ul class="navigation">
<?php if (Session::user_is_logged()) : ?>
	<li>
		<a href="/user/index">My Account</a>
		<ul class="navigation-submenu">
			<li>
				<a class="follow" href="/user/edit_username">Edit my username</a>
			</li>
			<li>
				<a class="follow" href="/user/edit_email">Edit my email</a>
			</li>
			<li>
				<a class="follow" href="/user/edit_password">Change Password</a>
			</li>
			<li>
				<a href="/login/logout">Logout</a>
			</li>
		</ul>
	</li>
<?php endif; ?>
</ul>