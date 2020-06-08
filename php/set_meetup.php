<?php

if(isset($_POST)){
include "connection.php";

$data = json_decode(file_get_contents('php://input'), true);
$sc_hdisp_book_id = base64_decode($data["sc_hdisp_book_id"]);
$sc_firstname = mysqli_real_escape_string($con, $data["sc_firstname"]);
$sc_lastname = mysqli_real_escape_string($con, $data["sc_lastname"]);
$sc_email = mysqli_real_escape_string($con, $data["sc_email"]);
$sc_contactno = mysqli_real_escape_string($con, $data["sc_contactno"]);
$sc_datetime = mysqli_real_escape_string($con, $data["sc_datetime"]);
$sc_location = mysqli_real_escape_string($con, $data["sc_location"]);

$sc_title = "";
$sc_edition = "";
$sc_author = "";
$sc_price = "";

	$getBookDetails = mysqli_query($con, "SELECT a.id, a.title, CONCAT(b.firstname, ' ', b.lastname) as author, a.price, a.cover_photo, a.edition, a.publisher, a.date_published, a.genre, a.current_condition FROM `books` as a LEFT JOIN `authors` as b ON (a.author_id = b.id) WHERE a.id = '".$sc_hdisp_book_id."'");

	if(mysqli_num_rows($getBookDetails) !=0){
		
		$fetchBookDetails = mysqli_fetch_array($getBookDetails);
		$sc_title = $fetchBookDetails["title"];
		$sc_edition = $fetchBookDetails["edition"];
		$sc_author = $fetchBookDetails["author"];
		$sc_price = $fetchBookDetails["price"];
		
		$insertTransaction = mysqli_query($con, "INSERT INTO `transactions` (book_id, customer_fname, customer_lname, customer_email, customer_mobile, meetup_date, meetup_location) VALUES ('".$sc_hdisp_book_id."', '".$sc_firstname."', '".$sc_lastname."', '".$sc_email."', '".$sc_contactno."', '".$sc_datetime."', '".$sc_location."')");

			if($insertTransaction){
				include "phpMailerClass.php";

				$body = "<html><body>Hi Admin, <br/><br/><b>".$sc_firstname." ".$sc_lastname."</b> wants to set a meeting to purchase a book. Please see below details:</p><br/><br/>";
				$body .= "<table cellpadding='0' cellspacing='0' style='width:100%; border-left:solid 1px #ccc; border-right:solid 1px #ccc; border-bottom:solid 1px #ccc; padding:0; font-family:calibri, arial;'>";
				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Book Title:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_title." ".$sc_edition."</td>
						</tr>";
						
				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Author:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_author."</td>
						</tr>";

				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Price:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_price."</td>
						</tr>";

				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Buyer's Name:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_firstname." ".$sc_lastname."</td>
						</tr>";

				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Buyer's Email:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_email."</td>
						</tr>";

				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Buyer's Contact No.:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_contactno."</td>
						</tr>";
						
				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Meetup Date:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_datetime."</td>
						</tr>";		

				$body .= "<tr>
							<td style='border-top:solid 1px #ccc; width:20%; padding:3px 0px 3px 7px' valign='top'><b>Meetup Location:</b></td>
							<td style='border-top:solid 1px #ccc; width:80%; padding:3px 0px 3px 7px'>".$sc_location."</td>
						</tr>";				
				$body .= "</table><br/><br/>Regards,<br/>Bookmark by Quisi.io<br/><br/><b><i>Please do not reply. This is an automated email.</i></b></body></html>";

				$email = new PHPMailer();
				$email -> From = $sc_email;
				$email -> FromName = $sc_firstname." ".$sc_lastname;
				$email -> Subject = "Bookmark - Meeting Schedule";
				$email -> Body = $body;
				$email -> AddAddress("silvadrian3@gmail.com");
				
				$email -> IsHTML(true);
					
					if(!$email -> Send()) {
						echo $email -> ErrorInfo;
					} else {
							echo 1;
						}
			}

		
	}


}
?>