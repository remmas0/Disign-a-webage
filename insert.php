<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angles";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// التأكد أن البيانات وصلت
if (isset($_GET['s1'], $_GET['s2'], $_GET['s3'], $_GET['s4'])) {
    $s1 = intval($_GET['s1']);
    $s2 = intval($_GET['s2']);
    $s3 = intval($_GET['s3']);
    $s4 = intval($_GET['s4']);

    // إدخال القيم في قاعدة البيانات
    $sql = "INSERT INTO angls (servo1, servo2, servo3, servo4) VALUES ($s1, $s2, $s3, $s4)";

    if ($conn->query($sql) === TRUE) {
        // الرجوع للصفحة الرئيسية بعد الحفظ
        header("Location: index.php");
        exit;
    } else {
        echo "❌ Error: " . $conn->error;
    }
} else {
    echo "⚠️ Missing data! Please send all servo values.";
}

$conn->close();
?>

