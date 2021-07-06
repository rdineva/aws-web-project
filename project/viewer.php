<?php 
require 'header.php';
require 'read.php';

$controls = $_POST;
$file_content = "";
$type = $controls['type'];
$speed = $controls['animation-speed'];
$css = "";
if ($type == 'ref') {
  $file_content = read_zip($controls['file']);  
  $css = 'animation-duration: 3s';
} else if ($type == 'text') {
  $file_content = read_text($controls['file']);
} else {
  echo '<p class="error>Невалидно пускане.</p>';
}

$css = 'background-color: ' . $controls['background-color'] . 
'; color: ' . $controls['text-color'] . 
'; font-family: ' . $controls['font-family'] .
'; line-height: ' . $controls['line-height'] . 
'; font-style: ' . $controls['font-style'] . 
'; font-weight: ' . $controls['font-weight'];

$animation_type = $controls['animation']; ?>

<span id="speed" style="display: none"><?php echo $speed;?></span>

<?php
$animation_wrapper_class = "";
if ($animation_type == 'star-wars') {
  $animation_wrapper_class = "star-wars";
}


?>

<div class="to-animate <?php echo $animation_wrapper_class;?>" id="animation-wrapper" style='<?php echo $css;?>'>
  <button id="play" class="option player">
    <div class="img-container play">
      <img src="images/play.svg" alt="Play button"/>
    </div>
    <div class="img-container pause">
      <img src="images/pause.svg" alt="Pause button"/>
    </div>
  </button>

  <div class="content" style="animation-play-state: running; animation-name: <?php echo $animation_type; ?>">
      <?php echo $file_content ?>
  </div>
</div>

<?php
  require 'footer.php';
?>