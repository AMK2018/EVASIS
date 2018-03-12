<?php 
	//$con = mysqli_connect("138.128.167.194", "demexico_root", "2ybC10(FWk3I", "demexico_controlpersonal");
	$con = mysqli_connect("localhost", "root", "", "evasis");
	// Check connection
	if (mysqli_connect_errno())
	{
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

?>