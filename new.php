<?php

    $flash_message  = "";
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $name = $_POST['name'];
        $art = $_POST['art'];
        $adresse = $_POST['adresse'];
        $land = $_POST['land'];
        $tag = $_POST['tag'];
        $url = $_POST['url'];
        
        $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
        $db['dbname'] = ltrim($db['path'], '/');  
        $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
        $db_username = 'root';
        $db_password = '';
        
        // DB接続情報設定・SQL準備・接続
        
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
        ); 
        
        $pdo = new PDO($dsn, $db_username, $db_password, $options);
        
        $sql = "insert into prufungen(name, art, adresse, land, tag, url) values(:name, :art, :adresse, :land, :tag, :url)";
        $stmt = $pdo -> prepare($sql);
        
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':art', $art, PDO::PARAM_STR);
        $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
        $stmt->bindParam(':land', $land, PDO::PARAM_STR);
        $stmt->bindParam(':tag', $tag, PDO::PARAM_STR);
        $stmt->bindParam(':url', $url, PDO::PARAM_STR);
                    
        $stmt -> execute();
        
        $flash_message = "登録が完了しました";
    }

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="shortcut icon" href="favicon.ico">

        <title>試験情報登録</title>
        <style>
            h1{
                color: red;
                border: solid 2px red;
                border-radius: 30px;
                padding: 10px;
            }
            h2{
                color: red;
                background-color: pink;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row mt-2">
                <h1 class="text-center col-sm-12">新規試験情報登録</h1>
            </div>
            <div class="row mt-2">
                <h2 class="text-center col-sm-12"><?php print $flash_message; ?></h1>
            </div>
            <div class="row mt-2">
                <form class="col-sm-12" action="new.php" method="POST">
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">試験会場名</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">試験名</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="art" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-2 col-form-label">住所</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="adresse" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-2 col-form-label">州</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="land" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-2 col-form-label">日時</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="tag" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-2 col-form-label">url</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="url" required>
                        </div>
                    </div>
                    
                    
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <div class="offset-2 col-10">
                            <button type="submit" class="btn btn-primary form-control" id="upload">登録</button>
                        </div>
                    </div>
                </form>
            </div>
             <div class="row mt-5">
                <a href="index.php" class="btn btn-primary">トップページへ</a>
            </div>
        </div>
        

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS, then Font Awesome -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>
        <script>
            
            $(function() {
                
              var file = null; // 選択されるファイル
              var blob = null; // 画像(BLOBデータ)
              const THUMBNAIL_WIDTH = 300; // 画像リサイズ後の横の長さの最大値
              const THUMBNAIL_HEIGHT = 300; // 画像リサイズ後の縦の長さの最大値
            
              // ファイルが選択されたら
              $('input[type=file]').change(function() {
          
                // ファイルを取得
                file = $(this).prop('files')[0];
                // 選択されたファイルが画像かどうか判定
                if (file.type != 'image/jpeg' && file.type != 'image/png') {
                  // 画像でない場合は終了
                  file = null;
                  blob = null;
                  return;
                }
            
                // 画像をリサイズする
                var image = new Image();
                var reader = new FileReader();
                reader.onload = function(e) {
                  image.onload = function() {
                    var width, height;
                    if(image.width > image.height){
                      // 横長の画像は横のサイズを指定値にあわせる
                      var ratio = image.height/image.width;
                      width = THUMBNAIL_WIDTH;
                      height = THUMBNAIL_WIDTH * ratio;
                    } else {
                      // 縦長の画像は縦のサイズを指定値にあわせる
                      var ratio = image.width/image.height;
                      width = THUMBNAIL_HEIGHT * ratio;
                      height = THUMBNAIL_HEIGHT;
                    }
                    // サムネ描画用canvasのサイズを上で算出した値に変更
                    var canvas = $('#canvas')
                                 .attr('width', width)
                                 .attr('height', height);
                    var ctx = canvas[0].getContext('2d');
                    // canvasに既に描画されている画像をクリア
                    ctx.clearRect(0,0,width,height);
                    // canvasにサムネイルを描画
                    ctx.drawImage(image,0,0,image.width,image.height,0,0,width,height);
            
                    // canvasからbase64画像データを取得
                    var base64 = canvas.get(0).toDataURL('image/jpeg');        
                    // base64からBlobデータを作成
                    var barr, bin, i, len;
                    bin = atob(base64.split('base64,')[1]);
                    len = bin.length;
                    barr = new Uint8Array(len);
                    i = 0;
                    while (i < len) {
                      barr[i] = bin.charCodeAt(i);
                      i++;
                    }
                    blob = new Blob([barr], {type: 'image/jpeg'});
                    console.log(blob);
                  }
                  image.src = e.target.result;
                }
                reader.readAsDataURL(file);
              });
            
            });
        </script>
    </body>
</html>