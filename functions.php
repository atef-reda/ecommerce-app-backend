<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null)
{
    global $con;
    $data = array();
    $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if ($count > 0){
        echo json_encode(array("status" => "success", "data" => $data));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    return $count;
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest)
{
  global $msgError;
  $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
  $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
  $imagesize  = $_FILES[$imageRequest]['size'];
  $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
  $strToArray = explode(".", $imagename);
  $ext        = end($strToArray);
  $ext        = strtolower($ext);

  if (!empty($imagename) && !in_array($ext, $allowExt)) {
    $msgError = "EXT";
  }
  if ($imagesize > 2 * MB) {
    $msgError = "size";
  }
  if (empty($msgError)) {
    move_uploaded_file($imagetmp,  "../upload/" . $imagename);
    return $imagename;
  } else {
    return "fail";
  }
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}

function printFailure($msg="none"){
    echo json_encode(array("status"=>"failure","message"=>$msg));
}

function sendEmail($to, $title, $body){
    $header = "From: support@waelabohamza.com " . "\n" . "CC: waeleagle1243@gmail.com";
    mail($to, $title, $body, $header);
    echo "Success";
}




/*********************************************** */

// 🔹 1. Define Constants
// php
// Copy
// Edit
// define("MB", 1048576);
// This defines a constant MB to represent 1 Megabyte (MB) = 1048576 bytes.
// It is later used to restrict file upload size.
// 🔹 2. filterRequest($requestname)
// php
// Copy
// Edit
// function filterRequest($requestname)
// {
//   return htmlspecialchars(strip_tags($_POST[$requestname]));
// }
// This function sanitizes user input from the $_POST request.
// strip_tags() removes HTML and PHP tags.
// htmlspecialchars() converts special characters (like < and >) to HTML entities.
// Use case: Prevents XSS (Cross-Site Scripting) attacks.
// 🔹 3. getAllData($table, $where = null, $values = null)
// php
// Copy
// Edit
// function getAllData($table, $where = null, $values = null)
// {
//     global $con;
//     $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
//     $stmt->execute($values);
//     $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     $count  = $stmt->rowCount();
//     if ($count > 0){
//         echo json_encode(array("status" => "success", "data" => $data));
//     } else {
//         echo json_encode(array("status" => "failure"));
//     }
//     return $count;
// }
// Retrieves all records from a database table.
// Uses prepared statements to prevent SQL injection.
// If records exist, returns them as a JSON response.
// If no records exist, returns "status": "failure".
// Example usage:
// php
// Copy
// Edit
// getAllData("users", "id = ?", [5]); 
// This will get data from the users table where id = 5.
// 🔹 4. insertData($table, $data, $json = true)
// php
// Copy
// Edit
// function insertData($table, $data, $json = true)
// {
//     global $con;
//     foreach ($data as $field => $v)
//         $ins[] = ':' . $field;
//     $ins = implode(',', $ins);
//     $fields = implode(',', array_keys($data));
//     $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

//     $stmt = $con->prepare($sql);
//     foreach ($data as $f => $v) {
//         $stmt->bindValue(':' . $f, $v);
//     }
//     $stmt->execute();
//     $count = $stmt->rowCount();
//     if ($json == true) {
//     if ($count > 0) {
//         echo json_encode(array("status" => "success"));
//     } else {
//         echo json_encode(array("status" => "failure"));
//     }
//   }
//     return $count;
// }
// Inserts new data into a table.
// Uses prepared statements to prevent SQL injection.
// If insertion is successful, returns "status": "success".
// Example usage:
// php
// Copy
// Edit
// insertData("users", ["name" => "John", "email" => "john@example.com"]);
// This will insert a new user into the users table.
// 🔹 5. updateData($table, $data, $where, $json = true)
// php
// Copy
// Edit
// function updateData($table, $data, $where, $json = true)
// {
//     global $con;
//     $cols = array();
//     $vals = array();

//     foreach ($data as $key => $val) {
//         $vals[] = "$val";
//         $cols[] = "`$key` =  ? ";
//     }
//     $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

//     $stmt = $con->prepare($sql);
//     $stmt->execute($vals);
//     $count = $stmt->rowCount();
//     if ($json == true) {
//     if ($count > 0) {
//         echo json_encode(array("status" => "success"));
//     } else {
//         echo json_encode(array("status" => "failure"));
//     }
//     }
//     return $count;
// }
// Updates existing records in a table.
// Uses prepared statements for security.
// Returns "status": "success" if update is successful.
// Example usage:
// php
// Copy
// Edit
// updateData("users", ["name" => "Jane"], "id = 5");
// This updates the name field of the user with id = 5.
// 🔹 6. deleteData($table, $where, $json = true)
// php
// Copy
// Edit
// function deleteData($table, $where, $json = true)
// {
//     global $con;
//     $stmt = $con->prepare("DELETE FROM $table WHERE $where");
//     $stmt->execute();
//     $count = $stmt->rowCount();
//     if ($json == true) {
//         if ($count > 0) {
//             echo json_encode(array("status" => "success"));
//         } else {
//             echo json_encode(array("status" => "failure"));
//         }
//     }
//     return $count;
// }
// Deletes records from a database table.
// Uses prepared statements for security.
// Returns "status": "success" if deletion is successful.
// Example usage:
// php
// Copy
// Edit
// deleteData("users", "id = 5");
// This deletes the user with id = 5.
// 🔹 7. imageUpload($imageRequest)
// php
// Copy
// Edit
// function imageUpload($imageRequest)
// {
//   global $msgError;
//   $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
//   $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
//   $imagesize  = $_FILES[$imageRequest]['size'];
//   $allowExt   = array("jpg", "png", "gif", "mp3", "pdf");
//   $strToArray = explode(".", $imagename);
//   $ext        = end($strToArray);
//   $ext        = strtolower($ext);

//   if (!empty($imagename) && !in_array($ext, $allowExt)) {
//     $msgError = "EXT";
//   }
//   if ($imagesize > 2 * MB) {
//     $msgError = "size";
//   }
//   if (empty($msgError)) {
//     move_uploaded_file($imagetmp,  "../upload/" . $imagename);
//     return $imagename;
//   } else {
//     return "fail";
//   }
// }
// Handles file uploads.
// Validates file extension (jpg, png, gif, mp3, pdf).
// Limits file size to 2MB.
// Moves the uploaded file to the ../upload/ directory.
// Returns the file name if successful, "fail" otherwise.
// Example usage:
// php
// Copy
// Edit
// $filename = imageUpload("userImage");
// 🔹 8. deleteFile($dir, $imagename)
// php
// Copy
// Edit
// function deleteFile($dir, $imagename)
// {
//     if (file_exists($dir . "/" . $imagename)) {
//         unlink($dir . "/" . $imagename);
//     }
// }
// Deletes a file from the server.
// Example usage:
// php
// Copy
// Edit
// deleteFile("../upload", "image123.jpg");
// 🔹 9. checkAuthenticate()
// php
// Copy
// Edit
// function checkAuthenticate()
// {
//     if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
//         if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
//             header('WWW-Authenticate: Basic realm="My Realm"');
//             header('HTTP/1.0 401 Unauthorized');
//             echo 'Page Not Found';
//             exit;
//         }
//     } else {
//         exit;
//     }
// }
// Implements Basic Authentication.
// If the username/password are incorrect, it returns a 401 Unauthorized error.
// Example usage:
// php
// Copy
// Edit
// checkAuthenticate();
// ✅ Summary
// The script handles CRUD database operations.
// It implements file uploads and deletes files.
// It secures user inputs and prevents SQL injection.
// Uses Basic Authentication for security.
// Let me know if you need more explanation! 🚀