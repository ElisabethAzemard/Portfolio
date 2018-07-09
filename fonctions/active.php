<?php
	function active($url){
		if (htmlspecialchars($_SERVER["REQUEST_URI"]) == $url){
		echo ' class="active"';
		}
	}
?>