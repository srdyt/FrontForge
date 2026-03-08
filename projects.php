<?php
$host = "sql305.infinityfree.com";
$username = "if0_41253895";
$password = "NOPE";
$database = "if0_41253895_frontforge";

$conn = new mysqli($host, $username, $password, $database);

$result = $conn->query("SELECT * FROM projects");

if ($result->num_rows == 0) {
    echo "<p>No projects yet.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='project'>";
        echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "</div>";
    }
}
?>