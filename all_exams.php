<?php

    //ヘッダー情報の設定
    header("Content-Type: application/json; charset=utf-8");
    
    $data = array();
    
    // DB接続情報
    $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
    $db['dbname'] = ltrim($db['path'], '/');  
    $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
    $db_usernamedb_ = $db['user'];
    $db_password = $db['pass'];
    
    // DB接続情報設定・SQL準備・接続
    
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
    ); 
    
    $dbh = new PDO($dsn, $db_username, $db_password, $options);
    
    $sql = "select name, art, adresse, land, tag, url, lat, lng from prufungen";
    $sth = $dbh -> prepare($sql);
    $sth -> execute();
    
    //データを取得する
    $data = $sth -> fetchAll(PDO::FETCH_ASSOC);

    //jsonオブジェクト化
    $json_code = json_encode($data);

    echo $json_code;

?>