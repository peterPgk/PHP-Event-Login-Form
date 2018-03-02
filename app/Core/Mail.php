<?php
namespace Pgk\Core;

/**
 * Class Mail
 *
 * Handles everything regarding mail-sending.
 */
class Mail
{
	/** @var mixed variable to collect errors */
	private $error;

	/**
	 * Try to send a mail by using PHPMailer.
	 * Use PHPMailer installed via Composer.
	 *
	 * @param $user_email
	 * @param $from_email
	 * @param $from_name
	 * @param $subject
	 * @param $body
	 *
	 * @return bool
	 * @throws \Exception
	 * @throws \phpmailerException
	 */
	public function sendMail($user_email, $from_email, $from_name, $subject, $body)
	{
		$mail = new \PHPMailer;

		// if you want to send mail via PHPMailer using SMTP credentials
		if (Config::get('email.smtp')) {
			// set PHPMailer to use SMTP
			$mail->IsSMTP();
			$mail->isHTML(true);

			$mail->SMTPDebug    = 0;
			$mail->SMTPAuth     = Config::get('email.smtp_auth');
			$mail->SMTPSecure   = Config::get('email.smtp_encryption');
			$mail->Host         = Config::get('email.smtp_host');
			$mail->Username     = Config::get('email.smtp_username');
			$mail->Password     = Config::get('email.smtp_password');
			$mail->Port         = Config::get('email.smtp_port');
		} else {
			$mail->IsMail();
		}

		// fill mail with data
		$mail->From     = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($user_email);
		$mail->Subject  = $subject;
		$mail->Body     = $body;

		// try to send mail, put result status (true/false into $wasSendingSuccessful)
		$wasSendingSuccessful = $mail->Send();

		if ($wasSendingSuccessful) {
			return true;
		} else {
			// if not successful, copy errors into Mail's error property
			$this->error = $mail->ErrorInfo;
			
			return false;
		}
	}


    /**
     * The different mail sending methods write errors to the error property $this->error,
     * this method simply returns this error / error array.
     *
     * @return mixed
     */
	public function getError()
	{
		return $this->error;
	}
}
