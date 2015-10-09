<?php
// Script to test if the CURL extension is installed on this server

// Define function to test
function _is_curl_installed() {
	if  (in_array  ('curl', get_loaded_extensions())) {
		return true;
	}
	else {
		return false;
	}
}

// Ouput text to user based on test
if (_is_curl_installed()) {
  echo "cURL is installed on this server";
} else {
  echo "cURL is NOT installed on this server";
}
?>