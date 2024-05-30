<?php
if (isset($_COOKIE['admin'])) {
	setcookie('admin', '');
}
exit(header("location: index.php"));
?>