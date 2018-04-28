<?php
/**
 * Created by PhpStorm.
 * User: HIROKI_N
 * Date: 15/03/07
 * Time: 23:58
 */
// === Created by Azure PDT ===
$host = "＊＊＊＊＊";
$user = "＊＊＊＊＊";
$pwd = "＊＊＊＊＊";
$db = "＊＊＊＊＊";

// === xml生成のインスタンス ===
$dom = new DomDocument('1.0', 'UTF-8');
$root = $dom->appendChild($dom->createElement('homeworks'));

$x_today = $root->appendChild($dom->createElement('today'));
$x_tomorrow = $root->appendChild($dom->createElement('tomorrow'));
$x_after_tomorrow = $root->appendChild($dom->createElement('after_tomorrow'));
$x_another = $root->appendChild($dom->createElement('another'));
$x_done = $root->appendChild($dom->createElement('done'));

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
//
//if ( $_GET['json'] == 1 ) {
//
//    // ファイルからJSONを読み込み
//    $json = file_get_contents("task.json");
//
//    // 文字化けするかもしれないのでUTF-8に変換
//    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
//
//    // オブジェクト毎にパース
//    // trueを付けると連想配列として分解して格納してくれます。
//    $obj = json_decode($json, true);
//
//    // パースに失敗した時は処理終了
//    if ($obj === NULL) {
//        return;
//    }
//}else {

if ( !empty($_GET['format']) ) {
    if ($_GET['format'] == "xml") {
        header("Location: http://********.*****.***/homework/test.xml");
    }
}

    $sql_select = "SELECT * FROM api_student_assignments order by deadline";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();

    $obj = array(
        'meta'=>array(
            'code'=>"",
            'msg'=>""
        ),
        'data'=>array(
            'today'=>array(

            ),
            'tomorrow'=>array(

            ),
            'after_tomorrow'=>array(

            ),
            'another'=>array(

            ),
            'done'=>array(

            )
        )
    );

    foreach( $registrants as $registrant ) {
        $datetime1 = new DateTime($registrant['deadline']);
        $date = new DateTime();
        $datetime2 = new DateTime($date->format('Y-m-d'));
        $interval = $datetime2->diff($datetime1);

        if ( $datetime2 < $datetime1 ) {
            if ( $interval->format('%a') > 3 ) {

                $obj['data']['another'][] = array(
                    'id'=>$registrant['ID'],
                    'author'=>$registrant['author'],
                    'title'=>$registrant['title'],
                    'description'=>$registrant['description'],
                    'deadline'=>$registrant['deadline'],
                    'interval'=>$interval->format('%a')
                );
            }else if ( $interval->format('%a') == 3 ) {

                $obj['data']['after_tomorrow'][] = array(
                    'id'=>$registrant['ID'],
                    'author'=>$registrant['author'],
                    'title'=>$registrant['title'],
                    'description'=>$registrant['description'],
                    'deadline'=>$registrant['deadline'],
                    'interval'=>$interval->format('%a')
                );
            }else if ( $interval->format('%a') == 2 ) {

                $obj['data']['tomorrow'][] = array(
                    'id'=>$registrant['ID'],
                    'author'=>$registrant['author'],
                    'title'=>$registrant['title'],
                    'description'=>$registrant['description'],
                    'deadline'=>$registrant['deadline'],
                    'interval'=>$interval->format('%a')
                );
            }else if ( $interval->format('%a') == 1 ) {

                $obj['data']['today'][] = array(
                    'id'=>$registrant['ID'],
                    'author'=>$registrant['author'],
                    'title'=>$registrant['title'],
                    'description'=>$registrant['description'],
                    'deadline'=>$registrant['deadline'],
                    'interval'=>$interval->format('%a')
                );
            }
        }else {

            $obj['data']['done'][] = array(
                'id'=>$registrant['ID'],
                'author'=>$registrant['author'],
                'title'=>$registrant['title'],
                'description'=>$registrant['description'],
                'deadline'=>$registrant['deadline'],
                'interval'=>$interval->format('%a')
            );
        }


//    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">

        function alpha(name, button, interval) {

            var obj = document.getElementById(name);

            if (obj.style.opacity == 0.5) {

                obj.style.opacity = 100 / 100;
                obj.style.mozOpacity = 100 / 100;
                obj.style.filter = "alpha(opacity="+100+")";
                button.style.color = "#444444";
            }else {

                obj.style.opacity = 50 / 100;
                obj.style.mozOpacity = 50 / 100;
                obj.style.filter = "alpha(opacity="+50+")";
                button.style.color = "#FF1133";
            }

            alert(interval);

        }
    </script>

</head>
<body>

<!--navigation bar-->
<ul class="nav navbar-fixed-to nav-pills">
    <li class="active"><a href="#">ホーム</a></li>
    <li><a href="#">提出状況</a></li>
    <li><a href="#">メッセージ</a></li>
    <li><a href="account_2.php">アカウント</a></li>
</ul>
<br/><br/>

<div id="timeline">

    <?php
    if ( $obj['data']['today'] != NULL ) {

        echo '<div class="assignment-group">';

        $today = "　　　　　　　　　　　　　";
        echo "<h2>Today" . $today . $obj['data']['today'][0]['deadline'] . "</h2>";
        foreach ($obj['data']['today'] as $OBJ) {
            if ($OBJ != NULL) {
                echo
                    "<section id=\"" . $OBJ['id'] . "\" class=\"assignment-list\" style=\"display: block;\"><ul><li>" .
                    "<div class=\"assignment nopadding\">" .
                    "<div class=\"inline\">" .
                    "<button class=\"height glyphicon glyphicon-ok\" onclick=\"alpha('" . $OBJ['id'] . "', this, '" . $OBJ['interval'] . "')\"></button>" .
                    "</div>" .
                    "<div class=\"inline\">" .
                    "<p class=\"teacher-name\">" . $OBJ['author'] . "先生</p>" .
                    "<p class=\"title\">" . $OBJ['title'] . "</p>" .
                    "</div>";

                $x_id = $x_today->appendChild($dom->createElement('id'));
                $x_id->setAttribute("code", $OBJ['id']);
                $x_id->appendChild($dom->createElement('title', $OBJ['title']));
                $x_id->appendChild($dom->createElement('author', $OBJ['author']));
                $x_id->appendChild($dom->createElement('deadline', $OBJ['deadline']));
                $x_id->appendChild($dom->createElement('interval', $OBJ['interval']));

                if ($OBJ['description'] != NULL) {
                    echo "<p class=\"description\">" . nl2br($OBJ['description']) . "</p>";
                    $x_id->appendChild($dom->createElement('description', nl2br($OBJ['description'])));
                }
                echo "</div></li></ul></section>";
            } else {
                echo "No data";
            }
        }
        echo '</div>';
    }
    ?>



    <?php
    if ( $obj['data']['tomorrow'] != NULL ) {
        echo '<div class="assignment-group">';

        $tomorrow = "　　　　　　　　　　　";

        echo "<h2>Tomorrow" . $tomorrow . $obj['data']['tomorrow'][0]['deadline'] . "</h2>";
        foreach ($obj['data']['tomorrow'] as $OBJ) {
            if ($OBJ != NULL) {
                echo
                    "<section id=\"" . $OBJ['id'] . "\" class=\"assignment-list\" style=\"display: block;\"><ul><li>" .
                    "<div class=\"assignment nopadding\">" .
                    "<div class=\"inline\">" .
                    "<button class=\"height glyphicon glyphicon-ok\" onclick=\"alpha('" . $OBJ['id'] . "', this, '" . $OBJ['interval'] . "')\"></button>" .
                    "</div>" .
                    "<div class=\"inline\">" .
                    "<p class=\"teacher-name\">" . $OBJ['author'] . "先生</p>" .
                    "<p class=\"title\">" . $OBJ['title'] . "</p>" .
                    "</div>";

                $x_id = $x_tomorrow->appendChild($dom->createElement('id'));
                $x_id->setAttribute("code", $OBJ['id']);
                $x_id->appendChild($dom->createElement('title', $OBJ['title']));
                $x_id->appendChild($dom->createElement('author', $OBJ['author']));
                $x_id->appendChild($dom->createElement('deadline', $OBJ['deadline']));
                $x_id->appendChild($dom->createElement('interval', $OBJ['interval']));

                if ($OBJ['description'] != NULL) {
                    echo "<p class=\"description\">" . nl2br($OBJ['description']) . "</p>";
                    $x_id->appendChild($dom->createElement('description', nl2br($OBJ['description'])));
                }
                echo "</div></li></ul></section>";
            } else {
                echo "No data";
            }
        }
        echo '</div>';
    }
    ?>

    <?php
    if ( $obj['data']['after_tomorrow'] != NULL ) {

        echo '<div class="assignment-group">';
        $after_tomorrow = "　　　　　　　　";
        echo "<h2>After Tomorrow" . $after_tomorrow . $obj['data']['after_tomorrow'][0]['deadline'] . "</h2>";
        foreach ($obj['data']['after_tomorrow'] as $OBJ) {
            if ($OBJ != NULL) {
                echo
                    "<section id=\"" . $OBJ['id'] . "\" class=\"assignment-list\" style=\"display: block;\"><ul><li>" .
                    "<div class=\"assignment nopadding\">" .
                    "<div class=\"inline\">" .
                    "<button class=\"height glyphicon glyphicon-ok\" onclick=\"alpha('" . $OBJ['id'] . "', this, '" . $OBJ['interval'] . "')\"></button>" .
                    "</div>" .
                    "<div class=\"inline\">" .
                    "<p class=\"teacher-name\">" . $OBJ['author'] . "先生</p>" .
                    "<p class=\"title\">" . $OBJ['title'] . "</p>" .
                    "</div>";

                $x_id = $x_after_tomorrow->appendChild($dom->createElement('id'));
                $x_id->setAttribute("code", $OBJ['id']);
                $x_id->appendChild($dom->createElement('title', $OBJ['title']));
                $x_id->appendChild($dom->createElement('author', $OBJ['author']));
                $x_id->appendChild($dom->createElement('deadline', $OBJ['deadline']));
                $x_id->appendChild($dom->createElement('interval', $OBJ['interval']));

                if ($OBJ['description'] != NULL) {
                    echo "<p class=\"description\">" . nl2br($OBJ['description']) . "</p>";
                    $x_id->appendChild($dom->createElement('description', nl2br($OBJ['description'])));
                }
                echo "</div></li></ul></section>";
            } else {
                echo "No data";
            }
        }
        echo '</div>';
    }
    ?>

    <?php
    if ( $obj['data']['another'] != NULL ) {

        echo '<div class="assignment-group">';
        echo '<h2>Another</h2>';

        foreach ($obj['data']['another'] as $OBJ) {
            if ($OBJ != NULL) {
                echo
                    "<section id=\"" . $OBJ['id'] . "\" class=\"assignment-list\" style=\"display: block;\"><ul><li>" .
                    "<div class=\"assignment nopadding\">" .
                    "<div class=\"inline\">" .
                    "<button class=\"height glyphicon glyphicon-ok\" onclick=\"alpha('" . $OBJ['id'] . "', this, '" . $OBJ['interval'] . "')\"></button>" .
                    "</div>" .
                    "<div class=\"inline\">" .
                    "<p class=\"teacher-name\">" . $OBJ['author'] . "先生</p>" .
                    "<p class=\"title\">" . $OBJ['title'] . "</p>" .
                    "</div>";

                $x_id = $x_another->appendChild($dom->createElement('id'));
                $x_id->setAttribute("code", $OBJ['id']);
                $x_id->appendChild($dom->createElement('title', $OBJ['title']));
                $x_id->appendChild($dom->createElement('author', $OBJ['author']));
                $x_id->appendChild($dom->createElement('deadline', $OBJ['deadline']));
                $x_id->appendChild($dom->createElement('interval', $OBJ['interval']));

                if ($OBJ['description'] != NULL) {
                    echo "<p class=\"description\">" . nl2br($OBJ['description']) . "</p>";
                    $x_id->appendChild($dom->createElement('description', nl2br($OBJ['description'])));
                }
                echo "</div></li></ul></section>";
            } else {
                echo "No data";
            }
        }
        echo '</div>';
    }
    ?>



    <?php
    if ( $obj['data']['done'] != NULL ) {
        echo '<div class="assignment-group">';
        echo '<h2>Done</h2>';
        foreach ($obj['data']['done'] as $OBJ) {
            if ($OBJ != NULL) {
                echo
                    "<section id=\"" . $OBJ['id'] . "\" class=\"assignment-list done\" style=\"display: block;\"><ul><li>" .
                    "<div class=\"assignment nopadding\">" .
                    "<div class=\"inline\">" .
                    "<button class=\"height glyphicon glyphicon-ok b_done\" onclick=\"alpha('" . $OBJ['id'] . "', this, '" . $OBJ['interval'] * -1 . "')\"></button>" .
                    "</div>" .
                    "<div class=\"inline\">" .
                    "<p class=\"teacher-name\">" . $OBJ['author'] . "先生</p>" .
                    "<p class=\"title\">" . $OBJ['title'] . "</p>" .
                    "</div>";

                $x_id = $x_done->appendChild($dom->createElement('id'));
                $x_id->setAttribute("code", $OBJ['id']);
                $x_id->appendChild($dom->createElement('title', $OBJ['title']));
                $x_id->appendChild($dom->createElement('author', $OBJ['author']));
                $x_id->appendChild($dom->createElement('deadline', $OBJ['deadline']));
                $x_id->appendChild($dom->createElement('interval', $OBJ['interval']));

                if ($OBJ['description'] != NULL) {
                    echo "<p class=\"description\">" . nl2br($OBJ['description']) . "</p>";
                    $x_id->appendChild($dom->createElement('description', nl2br($OBJ['description'])));
                }
                echo "</div></li></ul></section>";
            } else {
                echo "No data";
            }
        }
        echo '</div>';
    }
    ?>


</div>
<?php

//XML を整形（改行・字下げ）して出力
    $dom->formatOutput = true;
//保存（上書き）
    $dom->save('test.xml');

?>
</body>
</html>

// 解析したjsonの表示
<pre>
<?php var_dump($obj); ?>
</pre>
