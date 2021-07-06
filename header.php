<?php 
  $keyword = '';
  if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Финални надписи</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <nav>
        <a href="index.php" class="menu-item">Начало</a>
        <a href="upload-choose.php" class="menu-item">Качване на файл</a>
        <a href="list.php" class="menu-item">Списък от качени файлове</a>
        <div class="search-container menu-item">
          <form action="list.php" method="get" class="search">
            <input type="text" placeholder="Търси.." name="search" value="<?php echo $keyword; ?>">
            <input type="submit" class="search-button" value="Търсене"></input>
          </form>
        </div>
      </nav>
    </header>