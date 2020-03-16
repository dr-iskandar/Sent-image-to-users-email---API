<?php
$target_dir = "uploads/";
$target_file = basename($_FILES["fileToUpload"]["name"]);
$nama = basename( $_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// $to = $_POST["name"];
$subject = “SUBJECT”;
$from = “email@gmail.com";
$headers = "From: $from\r\n";
$headers .= "MIME-Version: 1.0\r\n"
  ."Content-Type: multipart/mixed; boundary=\"1a2a3a\"";
 
$message .= "If you can see this MIME than your client doesn't accept MIME types!\r\n"
  ."--1a2a3a\r\n";
 
$message .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
  ."Content-Transfer-Encoding: 7bit\r\n\r\n"
  ."Hey my <b>good</b> friend here is a picture of you :)"
  ."<p><span style='color:red'><b>IT’S ME</b></span></p> \r\n"
  ."--1a2a3a\r\n";
  
  
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
 
$file = file_get_contents($nama);
 
$message .= "Content-Type: image/png; name=\"$nama\"\r\n"
  ."Content-Transfer-Encoding: base64\r\n"
  ."Content-disposition: attachment; file=\"$nama\"\r\n"
  ."\r\n"
  .chunk_split(base64_encode($file))
  ."--1a2a3a--";
 
// Send email
 
$success = mail($_POST["name"],$subject,$message,$headers);
   if (!$success) {
  echo "Mail to " . $_POST["name"] . " failed .";
   }else {
  echo "Success : Mail was send to " . $_POST["name"] ;
  header("Location:https://home.com");
   }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>