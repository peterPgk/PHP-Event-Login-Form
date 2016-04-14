<?php

namespace Pgk\Observers;


use Pgk\Contracts\Observer;
use Pgk\Core\Config;
use Pgk\Core\Mail;
use SplSubject;

class MailUserChangeData extends Observer {

	/**
	 * Receive update from subject
	 * @link http://php.net/manual/en/splobserver.update.php
	 *
	 * @param SplSubject $subject <p>
	 * The <b>SplSubject</b> notifying the observer of an update.
	 * </p>
	 *
	 * @return void
	 * @since 5.1.0
	 */
	public function update( SplSubject $subject ) {

		if( $subject->hasUser() && $subject->isFired() ) {

			$mail = new Mail();

			$email_to = $subject->getUser('email');
			$body = "Your account has been updated successfully\n";
			$body .= 'Your ' . $subject->getField() . ' has been changed to ' . $subject->getInput( 'new' );

			$mail->sendMail( $email_to, Config::get('email.email_from'), Config::get('email.name_from'), 'Your user account change data', $body );
		}

	}
}