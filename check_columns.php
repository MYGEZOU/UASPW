<?php
$m = new mysqli('localhost','root','','db_turnamen_esports');
$r = $m->query('SHOW COLUMNS FROM akun');
while($row = $r->fetch_assoc()) { echo $row['Field'] . "\n"; }
