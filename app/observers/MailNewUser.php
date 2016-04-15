<?php

namespace Pgk\Observers;


use Pgk\Contracts\Event;
use Pgk\Contracts\Observer;
use Pgk\Core\Config;
use Pgk\Core\Mail;

class MailNewUser extends Observer {

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param Event $subject <p>
	 * The <b>SplSubject</b> notifying the observer of an update.
	 * </p>
	 *
	 * @return void
	 * @since 5.1.0
	 */
	public function update( Event $subject ) {

		if(  $subject->hasUser() ) {
			$mail = new Mail();

			$body = "Your account's all set up and you're ready to start discovering and sharing!!!\n";
			$body .= 'Your new username is "' . $subject->getUser('username') . '" and your password is "' . $subject->getInput( 'password' ) . '"';


			$mail->sendMail( $subject->getUser('email'), Config::get('email.email_from'), Config::get('email.name_from'), 'New user registration', $body );
		}

	}
}