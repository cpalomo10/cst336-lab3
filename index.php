<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up Page</title>
        <link  href="css/styles.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    </head>
    <body>
       
    <h1>Sign Up </h1>
    
    <form id="signupForm" method="post" action="welcome.html">
    First Name:  <input type="text" name="fName"><br>
    Last Name:  <input type="text" name="lName"><br>
    Gender: <input type="radio" name="gender" value="m"> Male
            <input type="radio" name="gender" value="f"> Female<br><br>
                
    Zip Code: <input type="text" name="zip" id="zip"><br>
    City: <span id="city"></span><br>
    Latitude:   <span id="latitude"></span><br>
    Longitude:  <span id="longitude"></span><br><br>
    State:
    <select id="state" name="state">
        <option value="">Select One</option>
<!--        <option value="ca"> California</option>-->
<!--        <option value="ny"> New York</option>-->
<!--        <option value="tx"> Texas</option>-->
    </select><br />
    
    Select a County: <select id="county"></select><br><br>
    
    Desired Username: <input type="text"     id="username" name="username"><br>
                      <span id="usernameError"></span><br>
    Password:         <input type="password" id="password" name="password"><br>
                      <span id="passwordError"></span> <br /><br>
    Password again:   <input type="password" id="passwordAgain"><br>
                      <span id="passwordAgainError"></span> <br /><br>
        
    <input type="submit" value="Sign Up!">
    </form>
    
    <script>
        
        var usernameAvailable = false;
        
        // $(document).ready(function() {
        $.ajax({
               method: "GET",
               url: "https://cst336.herokuapp.com/projects/api/state_abbrAPI.php",
               dataType: "json",
               data: { "state": $("#state").val() },
               success: function(result, status) {
               $("#state").html("<option> Select One </select>");
               result.forEach(function(i) {
                $("#state").append("<option>" + i.state + "</option>");
                            });
               }
               });
               //       });
        
        //Displaying City from API after typing a xip code
        $("#zip").on("change", function() {
            //alert($("#zip").val());
            $.ajax({
                method: "GET",
                   url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
                dataType: "json",
                   data: { "zip": $("#zip").val() },
                success: function(result,status) {
                    //alert(result.City);
                   $("#city").html(result.city);
                }
            });//ajax city
                     
         $.ajax({
                method: "GET",
                url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
                dataType: "json",
                data: { "zip": $("#zip").val() },
                success: function(result,status) {
                $("#latitude").html(result.latitude);
                }
            });//ajax latitude
                     
         $.ajax({
                method: "GET",
                url: "https://cst336.herokuapp.com/projects/api/cityInfoAPI.php",
                dataType: "json",
                data: { "zip": $("#zip").val() },
                success: function(result,status) {
                $("#longitude").html(result.longitude);
                }
            });//ajax longitude
        });//zip
        
        $("#state").on("change", function() {
            //alert($("#state").val());
            $.ajax({
                method: "GET",
                url: "https://cst336.herokuapp.com/projects/api/countyListAPI.php",
                dataType: "json",
                data: { "state": $("#state").val() },
                success: function(result,status) {
                //alert(result[0].county);
                $("#county").html("<option> Select One </option>");
                result.forEach(function(i) {
                    $("#county").append("<option>" + i.county + "</option>");
                                  });
                   }
                });
            });//ajax county
        
        
        $("#username").change(function() {
            //alert($("#username").val());
            $.ajax({
                method: "GET",
                url: "https://cst336.herokuapp.com/projects/api/usernamesAPI.php",
                dataType: "json",
                data: { "username": $("#username").val() },
                success: function(result,status) {
                   if(result.available) {
                        $("#usernameError").html("Username is available!");
                        $("#usernameError").css("color", "green");
                        usernameAvailable = true;
                   } else {
                        $("#usernameError").html("Username is unavailable!");
                        $("#usernameError").css("color", "red");
                        usernameAvailable = false;
                   }
                }
            });//ajax usernameError
        }); //username
        
        $("#signupForm").on("submit", function(e) {
            //alert("usernameAvailable");
            if (!isFormValid()) {
                e.preventDefault();
            }
        });
        
        function isFormValid() {
            isValid = true;
            if (!usernameAvailable) {
                isValid = false;
            }
            
            if ($("#username").val().length == 0) {
                isValid = false;
                $("#usernameError").html("Username is required");
            }
            
            if ($("#password").val() != $("#passwordAgain").val()) {
                $("passwordAgainError").html("Password mismatch!");
                isValid = false;
            }
            
            if ($("#password").val().length < 6) {
                isValid = false;
                $("#passwordError").html("Password must be at least 6 characters long!");
            }
            
            return isValid;
        }
    
    
    </script>
    
    </body>
</html>
