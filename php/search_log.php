<?php
if(isset($_POST)){
include "connection.php";

$data = json_decode(file_get_contents('php://input'), true);
$sc_searchkey = base64_decode($data["sc_searchkey"]);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
				}
		
		$insertTransaction = mysqli_query($con, "INSERT INTO `search_log` (search_key, ip_address, user_agent) VALUES ('".$sc_searchkey."', '".$ip."', '".$user_agent."')");

		if($insertTransaction){
			echo 1;
		}
}
?>