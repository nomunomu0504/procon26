<?php

// ===Created by Azure PDT===
$host = "*********";
$user = "**********";
$pwd = "********";
$db = "***********";

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


/*
 * @GET    一覧取得
 * @POST   新規登録
 * @DELETE 指定エンティティの削除
 */

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {

    $req = array();
    parse_str($_SERVER['QUERY_STRING'], $req);
    // ファイルからJSONを読み込み
	$json = file_get_contents("classes.json");
 
	// 文字化けするかもしれないのでUTF-8に変換
	$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');

    $sql_select = "SELECT * FROM ".$req['query'];
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();

    echo '<pre>';
    var_dump($registrants);
    echo '</pre>';

}else if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

}else if ( $_SERVER['REQUEST_METHOD'] == 'DELETE' ) {

    echo "delete";
}

//echo '<pre>';
//var_dump($req);
//echo '<br/>';
//var_dump($json);
//echo '</pre>';