<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "angles";

// الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// جلب كل القيم المحفوظة
$sql = "SELECT * FROM angls ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Servo Motors Control Panel</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f6fa;
        text-align: center;
        margin: 0;
        padding: 20px;
    }
    h1 {
        color: #333;
        margin-bottom: 20px;
    }
    .servo-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        justify-content: center;
        max-width: 700px;
        margin: auto;
    }
    .servo-box {
        background: white;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    .servo-box label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    input[type="range"] {
        width: 100%;
    }
    .buttons {
        margin-top: 20px;
    }
    button {
        padding: 10px 20px;
        margin: 5px;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }
    .reset { background-color: #f39c12; }
    .save { background-color: #27ae60; }
    .submit { background-color: #2980b9; }
    table {
        width: 90%;
        margin: 30px auto;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid #ccc;
    }
    th, td {
        padding: 10px;
        text-align: center;
    }
    .load-btn {
        background-color: #16a085;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
    }
    .remove-btn {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
    }
</style>
</head>
<body>

<h1>Servo Motors Control Panel</h1>

<div class="servo-container">
    <div class="servo-box">
        <label>Servo 1 Angle: <span id="val1">0°</span></label>
        <input type="range" id="servo1" min="0" max="180" value="0" oninput="updateValue(1)">
    </div>
    <div class="servo-box">
        <label>Servo 2 Angle: <span id="val2">0°</span></label>
        <input type="range" id="servo2" min="0" max="180" value="0" oninput="updateValue(2)">
    </div>
    <div class="servo-box">
        <label>Servo 3 Angle: <span id="val3">0°</span></label>
        <input type="range" id="servo3" min="0" max="180" value="0" oninput="updateValue(3)">
    </div>
    <div class="servo-box">
        <label>Servo 4 Angle: <span id="val4">0°</span></label>
        <input type="range" id="servo4" min="0" max="180" value="0" oninput="updateValue(4)">
    </div>
</div>

<div class="buttons">
    <button class="reset" onclick="resetAngles()">Reset to 0°</button>
    <button class="save" onclick="savePosition()">Save Position</button>
    <button class="submit" onclick="submitToESP()">Submit to ESP</button>
</div>

<h2>Saved Positions</h2>
<table>
<tr>
    <th>ID</th>
    <th>Servo 1</th>
    <th>Servo 2</th>
    <th>Servo 3</th>
    <th>Servo 4</th>
    <th>Action</th>
</tr>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['servo1']."</td>
                <td>".$row['servo2']."</td>
                <td>".$row['servo3']."</td>
                <td>".$row['servo4']."</td>
                <td>
                    <button class='load-btn' onclick='loadPosition(".$row['servo1'].",".$row['servo2'].",".$row['servo3'].",".$row['servo4'].")'>Load</button>
                    <button class='remove-btn' onclick='removePosition(".$row['id'].")'>Remove</button>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No saved positions found</td></tr>";
}
$conn->close();
?>
</table>

<script>
function updateValue(num) {
    document.getElementById("val" + num).innerText = document.getElementById("servo" + num).value + "°";
}

function resetAngles() {
    for (let i = 1; i <= 4; i++) {
        document.getElementById("servo" + i).value = 0;
        updateValue(i);
    }
}

function savePosition() {
    let s1 = servo1.value;
    let s2 = servo2.value;
    let s3 = servo3.value;
    let s4 = servo4.value;
    window.location.href = `insert.php?s1=${s1}&s2=${s2}&s3=${s3}&s4=${s4}`;
}

function removePosition(id) {
    if (confirm("Delete this position?")) {
        window.location.href = `delete.php?id=${id}`;
    }
}

function loadPosition(s1, s2, s3, s4) {
    servo1.value = s1; servo2.value = s2; servo3.value = s3; servo4.value = s4;
    updateValue(1); updateValue(2); updateValue(3); updateValue(4);
    alert(`Position loaded into sliders`);
}

function submitToESP() {
    let s1 = servo1.value;
    let s2 = servo2.value;
    let s3 = servo3.value;
    let s4 = servo4.value;
    alert(`Sent to ESP: ${s1},${s2},${s3},${s4}`);
}
</script>

</body>
</html>
