<?php

require_once('session.php');
require_once('constant.php');

 $_connection = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE) or die("Can't Connect");
require_once('function.php');

