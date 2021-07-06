<?php
require 'aws.phar';
//require 'vendor/autoload.php';

use Aws\S3\S3Client;

  function read_text($filename) {

	$bucket = "web-project-files-bucket";

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
$s3 = new Aws\S3\S3Client([
        'region' => 'us-east-1',
        'version' => 'latest',
        'profile' => 'default'
]);


  $result = $s3->getObject(array(
      'Bucket' => $bucket,
      'Key'    => $filename,
	'SaveAs' => $filename
	));

        chmod($filename, 0777);
	
	$content="";
    if ($ext == 'txt') {
      $content= file_get_contents($filename);
    } else {
      $content = read_doc_docx($filename);
    }

	unlink($filename);
return $content;
  }

  function read_doc_docx($filename) {
    $zip = zip_open($filename);

    if (!$zip || is_numeric($zip)) {
      return false;
    }

    $content = '';

    while ($zip_entry = zip_read($zip)) {
      if (!zip_entry_open($zip, $zip_entry) || zip_entry_name($zip_entry) != "word/document.xml") {
        continue;
      }

      $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
      zip_entry_close($zip_entry);
    }

    zip_close($zip);

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $text = strip_tags($content);

    return $text;
  }

  function read_zip($filename) {
     $bucket = "web-project-files-bucket";

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
$s3 = new Aws\S3\S3Client([
        'region' => 'us-east-1',
        'version' => 'latest',
        'profile' => 'default'
]);

  $result = $s3->getObject(array(
      'Bucket' => $bucket,
      'Key'    => $filename,
 	'SaveAs' => $filename
   ));

	chmod($filename, 0777);

    $zip = new ZipArchive;
    $open = $zip->open($filename);
    if ($open === TRUE) {
      $destination_path = str_replace(".zip", "", $filename);
      if (!file_exists( $destination_path )) {
        mkdir($destination_path);
      }
      $zip->extractTo($destination_path);

      $content = file_get_contents( $destination_path . "/referat.html" );
      if ( !file_exists( $destination_path . "/referat.html" )) {
        echo "<p>В архива трябва да се съдържа файл referat.htm</p>";
        exit;
      }
      $source = new DOMDocument();
      libxml_use_internal_errors(true);
      $source->loadHTML($content);
      libxml_clear_errors();

      $inside = "";
      foreach($source->getElementsByTagName("body")->item(0)->childNodes as $child) {
          $inside .= $source->saveHTML($child);
      }

      $zip->close();
	unlink($filename);
system("rm -rf ".escapeshellarg($destination_path));

      return $inside;
    } else {
      echo "<p class='error'>Файлът не може да бъде отворен.</p>";
    }
  }
?>
