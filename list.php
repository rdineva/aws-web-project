<?php 
require 'database.php';
require 'header.php';

$filter = "";
$keyword = "";

if (isset($_GET["search"])) {
    $keyword = $_GET["search"];
}

if (isset($_GET["filter"]) && ($_GET["filter"] == 'ref' || $_GET["filter"] == 'text')) {
    $filter = $_GET["filter"]; 
}

get_list($keyword, $filter);

function get_list($keyword = "", $filter_type = "") {
    $db = new Database();
    $db->connect();

    $query_parameter = ""; ?>

    <div class="content">

<?php
    $search_query = "";

    if ($keyword != "") {
        $search_query = "search=$keyword";
        $query_parameter = " WHERE name LIKE '%" . $keyword . "%'";
        echo "<h1>Резултати от търсенето за " . $keyword . "</h1>";
    }
    else {
        echo "<h1>Списък от всички качени файлове</h1>";
    }

    echo "<div class='filters'>
            <h3><a href='?filter=text&$search_query'>Кредити</a></h3>
            <h3><a href='?filter=ref&$search_query'>Реферати</a></h3>
         </div>"; 

    if ($filter_type != "") {
        $clause = $keyword != "" ? ' AND' : ' WHERE';
        $query_parameter .= " $clause type IN ('$filter_type')";
    }

    $sql = "SELECT * FROM Files" . $query_parameter;
    $list_result = $db->query($sql);
    ?>
        <div class="list-all-files">
            <?php
            foreach($list_result as $file_link) {
                $type = $file_link['type'] == 'ref' ? 'реферат' : 'кредити';
                echo "<a href='controls.php?type=" . $file_link["type"]  ."&file=". $file_link["name"] . "'>" . $file_link["name"] . "</a>";
                echo "<p class=file-info>Тип: " . $type . ", Качен на: " . $file_link['created_on'] . "</p>";
            }
            ?>
        </div>
    </div>

    <?php
}

?> 
<?php
require 'footer.php';
?>