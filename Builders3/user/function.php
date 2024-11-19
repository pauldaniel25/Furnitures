<?php
/*
function clean($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);

    return $input;
    
}
    */
    function clean($input) {
        if (is_array($input)) {
            // Recursively sanitize each element of the array
            return array_map('clean', $input);
        } else {
            // Trim whitespace and remove harmful HTML
            $input = trim($input);
            // Convert special characters to HTML entities to prevent XSS
            $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
            return $input;
        }
    }