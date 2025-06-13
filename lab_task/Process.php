<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['confirm'])) {
        $conn = mysqli_connect("localhost","root","","AQI");
        $fullname = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        $d_o_b = $_SESSION['birthday'];
        $gender = $_SESSION['gender'];
        $location = $_SESSION['location'];
        $zipcode = $_SESSION['zip'];
        $color = $_SESSION['favcolor'];
        $city = $_SESSION['city'];

        setcookie("color", $color, time()+86400,"/");        

        $sql = "INSERT INTO user_info (name, email, password, date_of_birth, gender, location, zip_code, city) 
                VALUES ('$fullname', '$email', '$password','$d_o_b','$gender', '$location', '$zipcode', '$city')";

       if (mysqli_query($conn, $sql)) {
        header("refresh:2; url=index.html");
        echo "<h3 style='color: green;'>Registration Successful!</h3>";
        exit();
        }  
     else 
        {
            echo "<h3 style='color: red;'>Error: " . mysqli_error($conn) . "</h3>";
        }

        mysqli_close($conn);
        session_destroy();
      
        exit();
    }

    if (isset($_POST['cancel'])) {
        session_destroy();
        header("Location: index.html"); 
        exit();
    }

   
    $fullname = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $d_o_b = $_POST["birthday"];
    $gender = $_POST["gender"];
    $location = $_POST["location"];
    $zipcode = $_POST["zip"];
    $color = $_POST['favcolor'];
    $city = $_POST["city"];
    $terms = isset($_POST["terms"]) ? "Agreed" : "Not Agreed";

    $_SESSION['username'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['birthday'] = $d_o_b;
    $_SESSION['gender'] = $gender;
    $_SESSION['location'] = $location;
    $_SESSION['zip'] = $zipcode;
    $_SESSION['favcolor'] = $color;
    $_SESSION['city'] = $city;
    $_SESSION['terms'] = $terms;

    echo "<div style='margin-top: 20px; padding: 15px; border: 1px solid #000; background-color:rgb(68, 156, 68);'>";
    echo "<h3>Submitted Registration Details</h3>";
    echo "<p><strong>Full Name:</strong> $fullname</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Birthday:</strong> $d_o_b</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>Location:</strong> $location</p>";
    echo "<p><strong>ZIP Code:</strong> $zipcode</p>";
    echo "<p><strong>Color:</strong> $color</p>";
    echo "<p><strong>City:</strong> $city</p>";
    echo "<p><strong>Terms:</strong> $terms</p>";
    echo "</div>";
}

?>

<form method="post" style="margin-top: 20px;">
    <button type="submit" name="confirm">Confirm</button>
    <button type="submit" name="cancel">Cancel</button>
</form>

