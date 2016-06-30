<html>
<title>MySQL Test</title>
<body>

<h1>MySQL Test</h1>
<p>Test Start</p>

<?php

error_reporting(E_ALL);
ini_set('display_errors',1);

var_dump(function_exists('mysqli_connect'));

$con = mysqli_connect("127.0.0.1", "root", "123456", "information_schema") or die("Error " . mysqli_error($con));

// Check connection
if (mysqli_connect_errno()) {
  echo "<h5>Failed to connect to MySQL: </h5>" . mysqli_connect_error();
} else {
  echo "<h5>Succeed to connect to MySQL. </h5></br>";
}

$result = mysqli_query($con, "SELECT * FROM ENGINES");
while($row = mysqli_fetch_array($result))
{
  echo $row['ENGINE'] . " - " . $row['COMMENT'];
  echo "<br>";
}

mysqli_close($con);
?>

<p>Test End</p>
</body>
</html>
