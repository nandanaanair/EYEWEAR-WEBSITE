
<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'eyewear44';
$DATABASE_NAME = 'eyeweardb';

// $DATABASE_HOST = 'sql208.infinityfree.com';
// $DATABASE_USER = 'if0_35922095';
// $DATABASE_PASS = 'nandana2003';
// $DATABASE_NAME = 'if0_35922095_eyeweardb';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if(!$conn)
{
    echo "Connection Failed";
}
// else{
//     echo "Connection successful";
// }