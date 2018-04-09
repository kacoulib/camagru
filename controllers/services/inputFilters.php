<?php
  function check_input($data) {
    $data = trim($data); //Strip whitespace (or other characters) from the beginning and end of a string.%/
    $data = stripcslashes($data); //Returns string with backslashes stripped off.
    $data = htmlspecialchars($data); //Convert special characters to HTML entities.
    return $data;
  }

