var app = angular.module('bookSearchResult', []);
app.controller('bookSearchResultCtrl', function($scope, $http) {
	angular.element(document).ready(function(){
		var searchkey = GetQueryStringParams('k');
		$scope.searchResult = null;
		$scope.disp_title = "";
		$scope.disp_edition = "";
		$scope.disp_author = "";
		$scope.disp_price = "";
		$scope.disp_cover = "";
		
		$http.get("external/api/book_author_result.php?auth=759fec25840837881a8cfd8801f317ee&searchkey=" + searchkey).success(function(response){
			if(!isEmpty(response)){
				$scope.searchResult = response;
				$scope.resultcount = response.length + " book";
				$scope.resultcount += response.length > 1 ? "s":"";
			} else {
				$scope.resultcount = "No result";
			}			
				$("#page-load").hide();
				$("#container").show();
		});
	});
	
	$scope.start_schedule = function(v_book_id, v_title, v_edition, v_author, v_price, v_cover){
		document.getElementById("shedule_form").style.display="block";
		$scope.disp_book_id = v_book_id;
		$scope.disp_title = v_title;
		$scope.disp_edition = v_edition;
		$scope.disp_author = v_author;
		$scope.disp_price = v_price;
		$scope.disp_cover = v_cover;
	}
	
	$scope.close_schedule = function(){
		document.getElementById("shedule_form").style.display="none";
		$scope.disp_title = "";
		$scope.disp_edition = "";
		$scope.disp_author = "";
		$scope.disp_price = "";
		$scope.disp_cover = "";
	}
	
	$scope.set_meetup = function(){
		
		var msg = "";
		var color = "";
		var loc = "index.html";
		var params = {
			sc_hdisp_book_id: $("#hdisp_book_id").val(),
			sc_firstname: $("#sc_firstname").val(),
			sc_lastname: $("#sc_lastname").val(),
			sc_email: $("#sc_email").val(),
			sc_contactno: $("#sc_contactno").val(),
			sc_datetime: $("#sc_datetime").val(),
			sc_location: $("#sc_location").val()
		}

		$http({url: "php/set_meetup.php", method: 'POST', data: params}).success(function(response) {
			//console.log(response);
			if(isNaN(response)){
				msg = "Unexpected error encountered.";
				color = "#FF0000"; //red
			} else {
				msg = "Meetup successfully set! Please wait for our response shortly.";
				color = "#5cb85c"; //green
				}
				
			alert(msg); //custom message
			window.location = self.location;
		})
		.error(function(data, status) {
		   console.log("Data: " + data);
		   console.log("Status: " + status);
		});
	}
	
	$('.datetime_picker').datetimepicker({format: 'M d Y h:i A', validateOnBlur:false});
	$('.datetime_picker').off('mousewheel.disableScroll');
});
