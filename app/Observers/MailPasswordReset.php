<?php

namespace Pgk\Observers;


use Pgk\Contracts\Event;
use Pgk\Contracts\Observer;
use Pgk\Core\Config;
use Pgk\Core\Mail;

class MailPasswordReset extends Observer {

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

		if( $subject->hasUser() ) {

			$mail = new Mail();

			$link = Config::get('url') . 'login/handle_reset/' . urlencode( $subject->getUser( 'username' ) ) . '/' . urlencode( $subject->getUser( 'password_reset_token' ) );

			$email_to = $subject->getUser('email');
			$body = "Your requested to reset your password\n";
			$body .= "Please follow the link below to reset your current password\n";
			$body .= '<a href="'. $link .'" target="_blank">Password reset</a>';

			$mail->sendMail( $email_to, Config::get('email.email_from'), Config::get('email.name_from'), 'Your user account change data', $body );
		}

	}
}