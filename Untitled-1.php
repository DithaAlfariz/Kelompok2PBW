<?php
$target_dir = "uploads/";
if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
$bukti = time() . '_' . basename($_FILES["bukti"]["name"]);
move_uploaded_file($_FILES["bukti"]["tmp_name"], $bukti);