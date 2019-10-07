<?php
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
// funktsioon, mis kontrollib kasutaja sisestatud andmeid, et need oleksid sisestatud kasutajakonto loomisel