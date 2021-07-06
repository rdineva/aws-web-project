<?php
require 'aws.phar';
require 'vendor/autoload.php';

use Aws\S3\S3Client;

  require 'header.php';
  require 'database.php';
  $type = '';

  if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $upload_type = $type == 'text' ? 'текст' : 'кредити';
    $allowed_formats = '';

    if ($type == 'text') {
      $allowed_formats = 'DOC, DOCX и TXT';
    } else if ($type == 'ref') {
      $allowed_formats = 'ZIP';
    }
    
    if (isset($_POST['submit'])) {
      post_upload($type);
    }
  }
?>
<div class="content">
  <?php if ($type) {
    echo  "<form action='' method='post' enctype='multipart/form-data'>
            <p>Избери файл за качване от тип $type</p>    
            <p>Поволени формати за качване: $allowed_formats</p>
            <input type='file' name='file' id='file'>
            <input type='submit' value='Качване' name='submit'>
          </form>";
  }
  ?>
</div>

<?php 


  function upload_file($target_file, $type) {
    try {
      $db = new Database();
      $db->connect();
	$bucket = "web-project-files-bucket";

	$s3 = new Aws\S3\S3Client([
	'region' => 'us-east-1',
	'version' => 'latest',
	'profile' => 'default'
	]);


 	if($s3->putObject(array(
          'Bucket' => $bucket,
          'Key'    => $target_file,
         'SourceFile'   => $_FILES['file']['tmp_name']
	))) {
	      $sql = "INSERT INTO Files (name, type) VALUES ('$target_file', '" . $type . "')";
	      $db->exec($sql);
		echo "<p class='success'>Успешно качване!</p>";
	} else{
    	    echo 'error uploading to S3 Amazon';
        }
    }  catch(PDOException $e) {
      echo "<br>" . $e->getMessage() . "<br>";
    }
  }
  
  function post_upload($type) {
    $target_file =basename($_FILES["file"]["name"]);
    $upload_ok = 1;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
      $check_file_size = filesize($_FILES["file"]["tmp_name"]);
      
      if($check_file_size !== false) {
        $upload_ok = 1;
      } else {
        $upload_ok = 0;
      }
    }

    if ($_FILES["file"]["size"] > 500000) {
      echo "</p class='error'>Файлът е твърде голям.</p>";
      $upload_ok = -1;
    }

    if ($type == 'text') {
      if($file_type != "doc" && $file_type != "docx" && $file_type != "txt") {
        echo "<p class='error'>Позволените формати за качване на кредити са DOC, DOCX и TXT.</p>";
        $upload_ok = 0;
      }
    } else if ($type == 'ref') {
      if($file_type != "zip") {
        echo "<p class='error'>Позволеният формат за качване на реферат е ZIP.</p>";
        $upload_ok = 0;
      }
    }

    if ($upload_ok == 0) {
      echo "<p class='error'>Неуспешно качване!</p>";
    } else {
      	upload_file($target_file, $type);
    }
  }

  require 'footer.php';
?>
