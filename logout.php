<?php
SESSION_START();

unset($_COOKIE["uid"]);
unset($_COOKIE["token"]);
setcookie('uid', null, -1, '/');
setcookie('token', null, -1, '/');

unset($_SESSION['uid']);

SESSION_DESTROY();

header('location: .');