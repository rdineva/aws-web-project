<?php
  require 'header.php';
  $filename = $_GET['file'];
  $type = $_GET['type'];
?>

<div class="content">
  <form action="viewer.php" method="post" enctype="multipart/form-data" class="control-form">
    <h3><?php echo $filename ?></h3>

    <div class="control">
      <label for="animation">Вид на анимацията:</label>
      <select name="animation" id="animation-type">
        <option value='linear-credits'>Линейна</option>
        <option value='star-wars'>Star Wars</option>
      </select>
    </div>

    <div class="control">
      <label for="text-color">Цвят на текста:</label>
      <input type="color" name="text-color" id="text-color">
    </div>

    <div class="control">
      <label for="line-height">Line height:</label>
      <input type="number" name="line-height" id="line-height" min="0" max="25" step=".01" value="2">
    </div>

    <div class="control">
      <label for="background-color">Цвят на фона:</label>
      <input type="color" name="background-color" id="background-color" value="#bbf7e8">
    </div>

    <div class="control">
      <label for="font-family">Шрифт:</label>
      <select name="font-family" id="font-family">
        <option value='Arial, Helvetica, sans-serif'>Arial</option>
        <option value='"Arial Black", Gadget, sans-serif'>Arial Black</option>
        <option value='"Comic Sans MS", cursive, sans-serif'>Comic Sans MS</option>
        <option value='Impact, Charcoal, sans-serif'>Impact</option>
        <option value='"Times New Roman", Times, serif'>Times New Roman</option>
        <option value='"Lucida Sans Unicode", "Lucida Grande", sans-serif'>Lucida Sans Unicode</option>
        <option value='Tahoma, Geneva, sans-serif'>Tahoma</option>
        <option value='"Trebuchet MS", Helvetica, sans-serif'>Trebuchet MS</option>
        <option value='Verdana, Geneva, sans-serif'>Verdana</option>
      </select>
    </div>

    <div class="control">
      <label for="font-style">Стил на шрифта:</label>
      <select name="font-style" id="font-style">
        <option value='normal'>normal</option>
        <option value='italic'>italic</option>
      </select>
    </div>

    <div class="control">
      <label for="font-weight">Дебелина на шрифта:</label>
      <select name="font-weight" id="font-weight">
        <option value='normal'>normal</option>
        <option value='bold'>bold</option>
      </select>
    </div>

    <div class="control">
      <label for="animation-speed">Скорост на анимацията: </label>
      <input type="number" name="animation-speed" id="animation-speed" min="0.25" max="10" step=".25" value="1">
      <p class="more-info">По подразбиране е 1, с по-голяма стойност се забързва, с по-малка се намалява. Минимална стойност 0.25</p>
    </div>

    <div>
      <input type="text" style="display: none;" value="<?php echo $filename ?>" name="file" />
    </div>

    <div>
      <input type="text" style="display: none;" value="<?php echo $type ?>" name="type" />
    </div>

    <input type="submit" value="Избери" name="submit">
  </form>
</div>
<?php
  require 'footer.php';
?>

