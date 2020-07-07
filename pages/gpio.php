<?php
exec("gpio read 1", $status);
print_r($status[0]); //or var_dump($status);
?>