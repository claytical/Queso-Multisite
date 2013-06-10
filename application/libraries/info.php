<?php

class Info {

	public static function is_super() {
		$user = Sentry::user(Session::get(Config::get('sentry::sentry.session.user')));
		if ($user->super) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public static function notify($user_id, $subject, $body) {
		$user = User::find($user_id);
		$email = $user->email;
		$from = Session::get('course_name');
		if ($user->notify_email) {		

			Message::send(function($message) use ($email, $body, $subject, $from) {
			    $message->to($email);
			    $message->from('info@conque.so', $from);
			    $message->subject($subject);
		    	$message->body($body);
		    	$message->html(true);

				});		
		}
	}

}