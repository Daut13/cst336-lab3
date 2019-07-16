<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up Page</title>
		<link  href="css/styles.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	</head>
	
	<body>
		<h1> Sign Up </h1>
		<form id="signupForm" method="post" action="welcome.html">
			First Name: <input type="text" name="fName"><br>
			Last Name: <input type="text" name="lName"><br>
			Gender: <input type="radio" name="gender" value="m"> Male
					<input type="radio" name="gender" value="f"> Female<br><br>
			Zip Code: <input type="text" name="zip" id="zip"><br>
			City: <span id="city"></span><br>
			Latitude: <span id="latitude"></span><br>
			Longitude: <span id="longitude"></span><br><br>
			State:
			<select id="state" name="state">
				<option value="">Select One</option>
			</select><br />
		
			Select a County: <select id="county"></select><br><br>
		
			Desired Username: <input type="text" id="username" name="username"><br>
							  <span id="usernameError"></span><br>
			Password: <input type="password" id="password" name="password"><br>
			Password Confirmation: <input type="password" id="passwordAgain"><br>
							<span id="passwordAgainError"></span><br />
		
			<input type="submit" value="Sign up!">
		</form>
		<script>
		
			var usernameAvailable = false;
		
			//window.onload = populateState();
			
			//Display City from API after typing Zip Code
			$("#zip").on("change", function(){
				//alert($("#zip").val());
				$.ajax({
					  method: "GET",
					     url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
					dataType: "json",
					    data: { "zip": $("#zip").val()},
					success: function(result,status) {
					  
					    //alert(result);
					 	$("#city").html(result.city);
					    $("#latitude").html(result.latitude);
					    $("#longitude").html(result.longitude);
					} 
				});//ajax
			});//zip
			
			$("#state").on("change", function(){
				$.ajax({
					  method: "GET",
					     url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
					dataType: "json",
					    data: { "state": $("#state").val()},
					success: function(result,status) {
					  
						$("#county").html("<option> Select One </option>");
					    for (let i = 0; i < result.length; i++){
					    	$("#county").append("<option>" + result[i].county + "</option>");
					    }
					 
					} 
				});//ajax
			});//state
			
			$("#username").change(function(){
				$.ajax({
					  method: "GET",
					     url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
					dataType: "json",
					    data: { "username": $("#username").val()},
					success: function(result,status) {
					  
						if (result.available){
							$("#usernameError").html("Username is available!");
							$("#usernameError").css("color", "green");
							usernameAvailable = true;
						}
						else {
							$("#usernameError").html("Username is unavailable!");
							$("#usernameError").css("color", "red");
							usernameAvailable = false;
						}
					 
					} 
				});//ajax
			});//username
			
			$("#signupForm").on("submit", function(event){
				//alert("Submitting form...");
				if (!isFormValid()){
					event.preventDefault();
				}
			});
			
			function isFormValid(){
				var isValid = true;
				if (!usernameAvailable){
					isValid = false;
				}
				
				if ($("#username").val().length == 0){
					isValid = false;
					$("#usernameError").html("Username is required");
					$("#usernameError").css("color", "red");
				}
				
				if ($("#password").val() != $("#passwordAgain").val()){
					$("#passwordAgainError").html("Password Mismatch!");
					$("#passwordAgainError").css("color", "red");
					isValid = false;
				}
				
				if ($("#password").val().length < 6){
					$("#passwordAgainError").html("Password must be at least 6 characters.");
					$("#passwordAgainError").css("color", "red");
					isValid = false;
				}
				
				return isValid;
			}
			
			$("#state").on("click", function(){
					$.ajax({
						  method: "GET",
						     url: "https://cst336.herokuapp.com/projects/api/state_abbrAPI.php",
						dataType: "json",
						    data: { "state": $("#state").val()},
						success: function(result,status) {
						  	for (let i = 0; i < result.length; i++){
						  		$("#state").append("<option value='"+ result[i].usps.toLowerCase() + "'>"
						  				+ result[i].state + "</option>");
						  	}
						} 
					});//ajax
			});//state
			
		</script>
	</body>
	
</html>