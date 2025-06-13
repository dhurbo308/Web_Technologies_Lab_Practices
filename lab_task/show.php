<?php
    $color = $_COOKIE['color'];
    echo "<body style='background-color:$color;'></body>";
    // Check if the form was submitted and cities are selected
    if (isset($_POST['Cities']) && is_array($_POST['Cities'])) {
        $selectedCities = $_POST['Cities'];

        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'AQI');

        // Check the connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Create a SQL query to fetch AQI for selected cities
        $cityList = "";
        foreach ($selectedCities as $city) {
            $city = mysqli_real_escape_string($conn, $city); // prevent SQL injection
            $cityList .= "'" . $city . "',";
        }

        // Remove the last comma
        $cityList = rtrim($cityList, ',');

        // Final SQL query
        $sql = "SELECT Country, City, AQI FROM info WHERE City IN ($cityList)";

        // Run the query
        $result = mysqli_query($conn, $sql);

        // Check if we got any results
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Selected Cities and Their AQI</h2>";
            echo "<table border='1' cellpadding='8'>";
            echo "<tr><th>Country</th><th>City</th><th>AQI</th></tr>";

            // Loop through the results and display them in a table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" .htmlspecialchars($row['Country'])."</td>";
                echo "<td>" . htmlspecialchars($row['City']) . "</td>";
                echo "<td>" . htmlspecialchars($row['AQI']) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No AQI data found for selected cities.";
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo "No cities were selected.";
    }
    header("refresh:3; url:index.html");
?>
