<?php

	$name = $_GET['name'];
	if ($name == 'test') {
		echo '{"success":{"text":"Success"}}'; 
	}else {
		echo '{"error":{"text":"Text send did not match"}}';
	}


?>