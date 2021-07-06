<?php
  require 'header.php';
?>
<div class="content">
  <div class="options">
    <a href="upload.php?type=text" class="option">
      <div class="img-container">
        <img src="images/file-text.svg">
      </div>
      <h4>Качване на кредити</h4>
      <p class="upload-formats">Позволени файлови формати:<br/> DOC, DOCX, TXT</p>
    </a>
    <a href="upload.php?type=ref" class="option">
      <div class="img-container">
        <img src="images/file-archive.svg">
      </div>
      <h4>Качване на реферат</h4>
      <p class="upload-formats">Позволени файлови формати: <br/> ZIP</p>
    </a>
  </div>
</div>
<?php
  require 'footer.php';
?>