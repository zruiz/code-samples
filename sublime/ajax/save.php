<?php
//echo $_POST['comments'];

$f = fopen('data.txt', 'w');
fwrite($f, $_POST['comments']);
fclose($f);

echo "Data was saved";