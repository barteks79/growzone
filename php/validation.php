<?php

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_between($text, $min, $max) {
    return is_string($text) && strlen($text) >= $min && strlen($text) <= $max;
}
