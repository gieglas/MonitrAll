<!DOCTYPE html>
<html lang="en">
  <?php //session_start(); 
//	if (empty($_SESSION['user_name']) || (!$_SESSION['user_is_logged_in'])) {
//		include('webapp/login/redirect.php'); 
//	}
  ?>
  <?php include_once('webapp/tmpl/globalHead.tmpl'); ?>  
  <body>
    <?php include_once('webapp/tmpl/globalTop.tmpl'); ?>  
    <?php include_once('webapp/tmpl/globalContent.tmpl'); ?>  
    <!-- templates
      ================================================= -->
    <!-- Placed here for easy reading  -->
    <?php include_once('webapp/tmpl/tmplResults.tmpl'); ?>  
    <?php include_once('webapp/tmpl/tmplForms.tmpl'); ?>  
    <?php include_once('webapp/tmpl/about.tmpl'); ?>  
    <!-- Le javascript
    ================================================== -->
    <?php include_once('webapp/tmpl/jsResults.tmpl'); ?>  
  </body>
</html>

