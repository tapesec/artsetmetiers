<?php
$time_start = microtime(true); //récuperation du timestamp au début de l'execution de la page
define('DS', DIRECTORY_SEPARATOR);
define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('BASE_URL',dirname($_SERVER['SCRIPT_NAME'])); //dirname($_SERVER['SCRIPT_NAME']);
define('TEST', dirname(dirname($_SERVER['PHP_SELF'])));
require_once ROOT.DS.'core'.DS.'includes.php';
new Dispatcher();
debug($_GET);
//$_SESSION = array();
if(isset($_SESSION)){
	debug($_SESSION);
}
if(isset(Auth::$session)){
	//debug(auth::$session);
}
//debug($_POST);
debug($_SERVER);
//session_destroy();
$time_stop = microtime(true);
$time_exec = round($time_stop - $time_start, 5);
if(Config::$debug_level>0): ?>
<div style="position:static;bottom:0;background-color:red;padding:10px;color:white;">
	<?php echo 'Page executé en '.$time_exec.' secondes'; ?>
</div>
<?php endif; ?>
