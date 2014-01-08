<?php

	$freespace= disk_free_space("\\\\10.144.32.5\\Shared");

	echo '{"success":{"text":"Success'.$freespace.'"}}'; 
	

?>