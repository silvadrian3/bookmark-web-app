
var app = angular.module('bookSearch', []);
app.controller('bookSearchCtrl', function($scope, $http) {
	angular.element(document).ready(function(){
		
		$http.get("external/api/book_author_search.php?auth=759fec25840837881a8cfd8801f317ee").success(function(response) {
			suggestions = [];
			
			for(x=0; x < response.length; x++){
				vals = response[x].data;
				suggestions.push(vals);
			}
			//console.log(suggestions);
			$(".autofillSearch").autocomplete({ source: suggestions });
		});
	});
	
	$scope.start_search = function(){
		var searchkey = $("#searchkey").val();
		searchkey = searchkey.trim();
		searchkey = Base64.encode(searchkey.toString());
		errmsg = "Unexpected error encountered.";
		
		var params = {
			sc_searchkey: searchkey
		}

		$http({url: "php/search_log.php", method: 'POST', data: params}).success(function(response) {
			if(isNaN(response)){
				alert(errmsg);
			} else {
				window.location = "search-result.html?k=" + searchkey;
				}
		})
		.error(function(data, status) {
		   console.log("Data: " + data);
		   console.log("Status: " + status);
		   alert(errmsg);
		});
		
		
	}
});
