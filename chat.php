<?php
  include 'db.php';
  $query = "SELECT * FROM data ORDER BY id DESC";
  $run = $con->query($query);

  while($row = $run->fetch_array()) :
?>
<span><b><?php echo $row['name']; ?></b></span>
<span><?php echo $row['msg']; ?></span>
<br>
<?php endwhile;?>
