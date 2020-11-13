<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
       
        $fragen_id = $_GET['id'];
        
        $db = parse_url($_SERVER[' mysql://bca9c6ea51e0fc:86030753@eu-cdbr-west-03.cleardb.net/heroku_932d18c23319b85?reconnect=true']);
        $db['dbname'] = ltrim($db['path'], '/');  
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
        $username = 'root';
        $password = '';
      
        $fragen = "";
    
        try {

            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
            ); 
            
            $pdo = new PDO($dsn, $username, $password, $options);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            // PDO::fetch()でカレント1件を取得
            $stmt = $pdo->prepare('SELECT * FROM fragens where id = :id');
            $stmt->bindValue(':id', $fragen_id, PDO::PARAM_INT);
            $stmt->execute();
            
            $fragen = $stmt->fetch();
            
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
    }else{
        session_start();
        $dsn = 'mysql:host=localhost;dbname=deutsch';
        $username = 'root';
        $password = '';
        $fragen = '';
        
        $fragen_id = $_POST['id'];
        $comment = $_POST['comment'];
        
        try {
    
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
            ); 
            
            $pdo = new PDO($dsn, $username, $password, $options);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // $stmt = $pdo->prepare('SELECT * FROM fragens where id = :id');
            // $stmt->bindValue(':id', $fragen_id, PDO::PARAM_INT);
            // $stmt->execute();
            
            // $fragen = $stmt->fetch();
            
            // $pdo = new PDO($dsn, $username, $password, $options);
            // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 
            $stmt = $pdo->prepare('insert into antworten(fragen_id, comment) values(:fragen_id, :comment)');
            // if($fragen['antwort'] != null){
            //     $final_antwort = $fragen['antwort'] . '<br>・' . $antwort;
            // } else {
            //     $final_antwort = $antwort;
            // }
            
            $stmt->bindParam(':fragen_id', $fragen_id, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            
            $stmt->execute();
            
        } catch (PDOException $e) {
            echo 'PDO exception: ' . $e->getMessage();
            exit;
        }
        
        header('Location: index.php#fragens');
    }
        
    
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="main.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico">

        <title>投稿詳細</title>
        <style>
            h2{
                color: red;
                background-color: pink;
            }
            img{
                width: 60%;
            }
        </style>
    </head>
    <body class="show">
        <div class="container">
            <div class="row mt-2">
                <h1 class="text-center col-sm-12">質問に答える</h1>
            </div>
            <div class="row mt-2">
                <form class="col-sm-12" action="show.php" method="POST" enctype="multipart/form-data">
               
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">名前</label>
                        <div class="col-10">
                            <h1><?php print $fragen['name']; ?></h1>
                        </div>
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">質問</label>
                        <div class="col-10">
                            <h1><?php print $fragen['fragen']; ?></h1>
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">答え</label>
                        <div class="col-10">
                            <h1><?php print $fragen['antwort']; ?></h1>
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">答える</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="comment" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <input type="hidden" name="id" value="<?php print $fragen['id']; ?>">
                    </div>

                    <!-- 1行 -->
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-1">
                            <button type="submit" class="btn btn-warning">更新</button>
                        </div>
                    </div>
                </form>
             <div class="row mt-5">
                <a href="index.php#fragens" class="btn btn-warning">戻る</a>
            </div>
        </div>
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
    </body>
</html>