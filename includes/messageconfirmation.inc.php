<?php
if(isset($_SESSION['level']) && $_SESSION['level'] == 1){
	if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
}
?>
