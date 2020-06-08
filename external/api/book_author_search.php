<?php
include("../../php/connection.php");
if(isset($_GET["auth"]) || !empty($_GET["auth"])) {
	$k = "0zWPMriazi5sReWyfoRuCmiyuL9oSrWd2aOnSd2Soa9v7iro3r";
	$auth_key = md5($k);
	$get_auth = $_GET["auth"];

	$result = array();
	if($auth_key == $get_auth){
		
		$getBookTitles_Authors = mysqli_query($con, "(SELECT title as searchkey FROM `books`) UNION (SELECT CONCAT(firstname, ' ', lastname) as searchkey FROM `authors`) ORDER BY searchkey ASC");

		if(mysqli_num_rows($getBookTitles_Authors)!=0) {
			while($fetchBookTitles_Authors = mysqli_fetch_array($getBookTitles_Authors)) {
				extract($fetchBookTitles_Authors);
				$row_array['data'] = stripslashes($searchkey);
				array_push($result, $row_array);
			}
			echo json_encode($result);
		}
	}
}
?>