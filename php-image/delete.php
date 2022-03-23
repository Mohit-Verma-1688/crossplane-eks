<?php
  include './db.php';
  $id = $_GET['id'];
  $sql = "delete from demo_table where id=$id";
  $conn->query($sql);
  $conn->close();
  header("location: index.php");
?>
