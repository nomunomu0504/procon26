<html>
<head>
    <meta http-equiv="Content-Type"
          content="text/html; charset=utf-8">
    <title></title>

    <script language="JavaScript">
        <!--
        function checkForm(){
            if(document.info.author.value == "" ||
            document.info.title.value == "" ||
            document.info.description.value == "") {
                alert('空欄があります。入力してください');
                return false;
            }
            return true;
        }
        //-->
    </script>

</head>
<body>
<form name="info" method="POST" action=""  onSubmit="return checkForm()">
    <p>author&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
        <input type="text" name="author" /><br /></p>
    <p>title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
        <input type="text" name="title" size="50" /><br /></p>
    <p>description&nbsp;&nbsp;&nbsp;:
        <textarea name="description" rows="5" cols="48"></textarea><br/></p>
    <p>deadline&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
       <?php echo "<select name=\"yyyy\">";
       for ($i = 2015; $i < 2020; $i++) {
           echo "<option>".$i;
       }
       echo "</select> 年　";

       echo "<select name=\"mm\">";
       for ($i = 1; $i < 13; $i++) {
           echo "<option>".$i;
       }
       echo "</select> 月　";

       echo "<select name=\"dd\">";
       for ($i = 1; $i < 32; $i++) {
           echo "<option>".$i;
       }
       echo "</select> 日　";
       ?><br /></p>

    <input type="submit" value="投稿" />
</form>

<?php
//date_default_timezone_set('Asian/Tokyo');
/**
 * Created by PhpStorm.
 * User: HIROKI_N
 * Date: 15/03/08
 * Time: 18:25
 */
// ===Created by Azure PDT===
$host = "tcp:nr7zejdfr0.database.windows.net";
$user = "black_sleepman@nr7zejdfr0";
$pwd = "Hiroki0504";
$db = "procon-homework_db";

// Connect to database.
try {
    $conn = new PDO( "sqlsrv:Server= $host ; Database = $db ", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e){
    echo '<pre>';
    die(var_dump($e));
    echo '</pre>';
}

if(!empty($_POST['author'])) {
    try {
        $ID = rand();
        $author = $_POST['author'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        // Insert data
        $sql_insert = "INSERT INTO api_student_assignments (ID, author, title, description, deadline, created_at)VALUES (?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $ID);
        $stmt->bindValue(2, $author);
        $stmt->bindValue(3, $title);
        $stmt->bindValue(4, $description);

        $year = $_POST['yyyy'];
        $month = $_POST['mm'];
        $day = $_POST['dd'];
        $date = $year."-".$month."-".$day;
        $date_0 = date_format(date_create_from_format('Y-m-d', $date), 'Y-m-d');
        $stmt->bindValue(5, $date_0);
        $stmt->bindValue(6, gmdate( "Y/m/d", time()+9*3600 ));
        $stmt->execute();
    } catch (Exception $e) {
        echo '<pre>';
        die(var_dump($e));
        echo '</pre>';
    }
}

$sql_select = "SELECT * FROM api_student_assignments order by deadline";
$stmt = $conn->query($sql_select);
$registrants = $stmt->fetchAll();

if(count($registrants) > 0) {
    echo "<h2>People who are registered:</h2>";
    echo "<table border=\"3\">";
    echo "<tr><th>ID</th>";
    echo "<th>author</th>";
    echo "<th>title</th>";
    echo "<th>description</th>";
    echo "<th>deadline</th>";
    echo "<th>created_at</th>";

    foreach($registrants as $registrant) {
        echo "<tr><td>".$registrant['ID']."</td>";
        echo "<td>".$registrant['author']."</td>";
        echo "<td>".$registrant['title']."</td>";
        echo "<td>".$registrant['description']."</td>";
        echo "<td>".$registrant['deadline']."</td>";
        echo "<td>".$registrant['created_at']."</td></tr>";
    }
    echo "</table>";
} else {
    echo "<h3>No one is currently registered.</h3>";
}

foreach( $registrants as $registrant ) {
    $json[] = array(
        'id'=>$registrant['ID'],
        'author'=>$registrant['author'],
        'title'=>$registrant['title'],
        'description'=>$registrant['description'],
        'deadline'=>$registrant['deadline']
    );
}

echo '<pre>';
var_dump($json);
echo '</pre>';
