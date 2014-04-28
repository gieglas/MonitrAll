<?php 
header('Location: webapp/login/' , true, ($permanent === true) ? 301 : 302);
exit();
?>