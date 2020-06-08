<?php
include("../../php/connection.php");
if(isset($_GET["auth"]) || !empty($_GET["auth"])) {
	$k = "0zWPMriazi5sReWyfoRuCmiyuL9oSrWd2aOnSd2Soa9v7iro3r";
	$auth_key = md5($k);
	$get_auth = $_GET["auth"];

	$result = array();
	if($auth_key == $get_auth){
		
		$searchkey = $_GET["searchkey"];
		$searchkey = base64_decode(trim($searchkey));
		$searchkey = mysqli_real_escape_string($con, $searchkey);
		
		if($searchkey!=""){
			$getSearchResult = mysqli_query($con, "SELECT a.id, a.title, CONCAT(b.firstname, ' ', b.lastname) as author, a.price, a.cover_photo, a.edition, a.publisher, a.date_published, a.genre, a.current_condition FROM `books` as a LEFT JOIN `authors` as b ON (a.author_id = b.id) WHERE a.title LIKE '%".$searchkey."%' || CONCAT(b.firstname, ' ', b.lastname) LIKE '%".$searchkey."%'");

			if(mysqli_num_rows($getSearchResult)!=0) {
				while($fetchSearchResult = mysqli_fetch_array($getSearchResult)) {
					extract($fetchSearchResult);
					$row_array['book_id'] = base64_encode($id);
					$row_array['title'] = stripslashes($title);
					$row_array['author'] = stripslashes($author);
					$row_array['price'] = number_format(stripslashes($price), 2,'.',',');
					$row_array['cover_photo'] = stripslashes($cover_photo);
					$row_array['edition'] = stripslashes($edition);
					$row_array['publisher'] = stripslashes($publisher);
					$row_array['date_published'] = stripslashes($date_published);
					$row_array['genre'] = stripslashes($genre);
					$row_array['current_condition'] = stripslashes($current_condition);
					array_push($result, $row_array);
				}
				echo json_encode($result);
			}
		}
	}
}
?>