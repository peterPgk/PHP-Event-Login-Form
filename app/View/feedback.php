<?php

// get the feedback (they are arrays, to make multiple positive/negative messages possible)
use Pgk\Core\Session;

$feedback = Session::get('feedback');

if ( is_array( $feedback ) && count($feedback) > 0 ) {
    foreach ($feedback as $message) {
        echo '<div class="feedback '. key($message) .'">'. reset($message).'</div>';
    }
}