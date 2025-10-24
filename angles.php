<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angles";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب آخر صف (أحدث زوايا محفوظة)
$sql = "SELECT servo1, servo2, servo3, servo4 FROM angls ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// إذا فيه بيانات، نعرضها
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['servo1'] . "," . $row['servo2'] . "," . $row['servo3'] . "," . $row['servo4'];
} else {
    echo "0,0,0,0"; // إذا ما فيه بيانات
}

$conn->close();
?>
