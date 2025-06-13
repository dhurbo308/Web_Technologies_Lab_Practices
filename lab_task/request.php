<?php
    if(empty($_POST['login_email'] && $_POST['login_password']))
    {
        echo "login failed ";
    }

 else{

        $conn = mysqli_connect('localhost', 'root', '', 'AQI');

        if (!$conn) {
            die(" Connection failed: " . mysqli_connect_error());
        }

        if(!empty($_POST['login'])){
            $email=$_POST['login_email'];
            $password=$_POST['login_password'];
            $query="select * from user_info where email='$email' and password='$password'";
            $res=mysqli_query($conn ,$query);
            $count=mysqli_num_rows($res);
            if($count>0)
            {
                echo "<p style='color:green; font-size: 20px;'>Login successful</p>";
                $sql = "SELECT City FROM info";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                die(" Query failed: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) > 0) {
                echo "<h3 style='text-align:center; color:rgb(50, 147, 186);'>Select up to 10 Cities:</h3>";
                echo "<form method='POST' action='show.php'>";
                echo "<div id='City-checkboxes' style='border:2px solid black; border-radius:10px; background-color:rgb(173, 173, 199); margin-left:auto; margin-right:auto; width:400px;'>";

                while ($row = mysqli_fetch_assoc($result)) {
                    $city = htmlspecialchars($row['City']);
                    echo "<label><input type='checkbox' name='Cities[]' value='$city' onclick='limitCheckboxes(this)'> $city</label><br>";
                }

                echo "</div>";
                echo "<br><div style='width:40px; background-color:red; margin-left:auto; margin-right:auto;'><input type='submit' value='Submit' style='color:white; background-color: green;'></div>";
                echo "</form>";
                }   else {
                echo "No cities found in the database.";
                }

                mysqli_close($conn);
            }
            else
            {
                header("refresh:3; url=index.html");
                echo "<p style='color: red; font-size: 25px;'>Invalid Account! login unsuccessful.</p>";
                echo "<p style='color: green; font-size: 20px;'>Please registration first.</p>";
            }
            
        }



    }

?>

<script>
function limitCheckboxes(checkbox) {
    const max = 10;
    const checkboxes = document.querySelectorAll('#City-checkboxes input[type="checkbox"]');
    let checkedCount = 0;

    checkboxes.forEach(cb => {
        if (cb.checked) checkedCount++;
    });

    if (checkedCount > max) {
        alert("You can select a maximum of 10 cities.");
        checkbox.checked = false;
    }
}
</script>



