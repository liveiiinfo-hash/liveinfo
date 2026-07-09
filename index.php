<?php
include "config.php";

// Create a visitor ID cookie
if (!isset($_COOKIE['visitor_id'])) {

    $visitor = bin2hex(random_bytes(16));

    setcookie(
        "visitor_id",
        $visitor,
        time() + (365 * 24 * 60 * 60),
        "/"
    );

} else {

    $visitor = $_COOKIE['visitor_id'];

}

/*---------------------------------
CHECK IF VISITOR ALREADY ASSIGNED
----------------------------------*/

$sql = "SELECT phone_id
        FROM visitor_assignments
        WHERE visitor_id='$visitor'";

$result = mysqli_query($conn,$sql);

if(!$result){
    die(mysqli_error($conn));
}

if(mysqli_num_rows($result)>0)
{

    $row = mysqli_fetch_assoc($result);

    $phone_id = $row['phone_id'];

}
else
{

    /*---------------------------------
      GET NEXT NUMBER
    ----------------------------------*/
// Get the last assigned phone ID
$settings = mysqli_query($conn,
    "SELECT last_phone_id FROM settings WHERE id=1");

$data = mysqli_fetch_assoc($settings);

$last = $data['last_phone_id'];

// Find the next number
$next = mysqli_query($conn,
    "SELECT id
     FROM whatsapp_numbers
     WHERE id > '$last'
     ORDER BY id ASC
     LIMIT 1");

if(mysqli_num_rows($next) == 0)
{
    // Start again from the first number
    $next = mysqli_query($conn,
        "SELECT id
         FROM whatsapp_numbers
         ORDER BY id ASC
         LIMIT 1");
}

$row = mysqli_fetch_assoc($next);

$phone_id = $row['id'];

// Save the last assigned number
mysqli_query($conn,
    "UPDATE settings
     SET last_phone_id='$phone_id'
     WHERE id=1");

    mysqli_query($conn,"
        INSERT INTO visitor_assignments(visitor_id,phone_id)
        VALUES('$visitor','$phone_id')
    ");

}

/*---------------------------------
GET PHONE NUMBER
----------------------------------*/

$get = mysqli_query($conn,"
SELECT phone
FROM whatsapp_numbers
WHERE id='$phone_id'
");

$row = mysqli_fetch_assoc($get);

header("Location: https://wa.me/".$row['phone']);

exit();

?>