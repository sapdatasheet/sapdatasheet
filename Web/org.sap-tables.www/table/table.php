<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');

?>
<!DOCTYPE html>
<html>
<body>

<h1>ABAP Table</h1>
<p>The ER file</p>
<pre>
<?php
  $erd = new ERD('MSEG', ERD_Format::png);
  echo $erd->process();
?>
</pre>

<p>The Image</p>
<img src="/table/erd-png.php" alt="failed">

</body>
</html>

