<?php
include('config/db.php');

$dest_id = intval($_POST['dest_id']);
$name    = trim($_POST['name']);
$rating  = intval($_POST['rating']);
$comment = trim($_POST['comment']);

if($dest_id && $rating >=1 && $rating <=5){
  $stmt = $conn->prepare("INSERT INTO reviews(dest_id,name,rating,comment) VALUES(?,?,?,?)");
  $stmt->bind_param('isis',$dest_id,$name,$rating,$comment);
  $stmt->execute();
  $stmt->close();
}

// Redirect back to details page anchor
header("Location: details.php#destination-$dest_id");
exit;
?>
