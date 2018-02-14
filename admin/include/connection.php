<?php
require('constant.php');
require('session.php');

 $_connection = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE) or die("Can't Connect");

require('function.php');
