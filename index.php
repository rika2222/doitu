<?php
    session_start();
  
    $dsn = 'mysql:host=localhost;dbname=deutsch';
    $username = 'root';
    $password = '';
    $fragens = array();

    try {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
        ); 
        
        $pdo = new PDO($dsn, $username, $password, $options);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        $stmt = $pdo->query('SELECT * FROM fragens order by id desc');
    
        $fragens = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        $name = $_POST['name'];
        $email = $_POST['email'];
        $fragen = $_POST['fragen'];
        
        try {
    
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
            ); 
            
            $pdo = new PDO($dsn, $username, $password, $options);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            $stmt = $pdo -> prepare("INSERT INTO fragens (name, email, fragen) VALUES (:name, :email, :fragen)");
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':fragen', $fragen, PDO::PARAM_STR);
            
            $stmt->execute();
            
            header('Location: index.php#fragens');
        }catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
    }
    try {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // 失敗したら例外を投げる
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,   //デフォルトのフェッチモードはクラス
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',   //MySQL サーバーへの接続時に実行するコマンド
        ); 
        
        $pdo = new PDO($dsn, $username, $password, $options);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        $stmt = $pdo->query('SELECT * FROM prufungen order by id desc');
    
        $prufungen = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo 'PDO exception: ' . $e->getMessage();
        exit;
    }
    
?>
<!DOCTYPE html>
<html class="no-js" lang="ja">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ドイツ留学ナビ</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Ropa+Sans">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="//maps.google.com/maps/api/js?language=ja&sensor=false"></script>
    <script src="modernizr.custom.min.js"></script>
    <script src="jquery-1.10.2.min.js"></script>
    <script src="jquery-ui-1.10.3.custom.min.js"></script>
    <script src="jquery.ba-throttle-debounce.min.js"></script>
    <script src="jquery.smooth-scroll.min.js"></script>
    <script src="main.js"></script>

</head>
    <body>
        <div class="container-fluid">
            <header class="hero-header">
                <div class="slideshow">
                    <div class="slideshow-slides">
                        <a href="./" class="slide" id="slide-1"><img src="student.jpg" alt="" width="1600" height="580"></a>
                        <a href="./" class="slide" id="slide-2"><img src="dorf2.jpg" alt="" width="1600" height="580"></a>
                        <a href="./" class="slide" id="slide-3"><img src="gosler.jpeg" alt="" width="1600" height="580"></a>
                        <a href="./" class="slide" id="slide-4"><img src="Hohenzollern.jpg" alt="" width="1600" height="580"></a>
                        <a href="./" class="slide" id="slide-6"><img src="deutschessen.jpeg" alt="" width="1600" height="580"></a>
                    </div>
                    <div class="slideshow-nav">
                        <a href="#" class="prev">Prev</a>
                        <a href="#" class="next">Next</a>
                    </div>
                    <div class="slideshow-indicator"></div>
                </div>
            </header>
            <header class="page-header" role="banner">
                <div class="inner clearfix">
                    <h1 class="site-logo"><a href="./"><img src="20200919logo1.png" alt="ドイツ留学ナビ" height="60" width="200"></a></h1>
                    <nav class="primary-nav" role="navigation">
                        <ul>
                            <li><a href="#Text1">自己紹介</a></li>
                            <li><a href="#verfahren">留学までにやること</a></li>
                            <li><a href="#sprachdiv">語学試験</a></li>
                            <li><a href="#visum">ビザ取得</a></li>
                            <li><a href="#fragens">質問コーナー</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            </header>
            
            <div id="vorstellung" class="row">
                <div class="offset-md-1 col-md-3 fotovon">
                    <p class="fotovonmir"><a href="./"><img src="200928fotovonmir.png" alt="fotovonmir" height="400" width="400" class="avator_image"></a></p>
                    <div class="fotomaru circle-1"></div>
                    <div class="fotomaru circle-2"></div>
                    <div class="fotomaru circle-3"></div>
                    <div class="circle-7"></div>
                    <div class="circle-8"></div>
                    <div class="circle-9"></div>
                    <div class="circle-10"></div>
                </div>
                <div class="offset-md-1 col-md-5" id="Text1">
                    <h1 class="mir">自己紹介</h1>
                    <p class="text1">はいどうも！</p>
                    <div class="circle-4"></div>
                    <div class="circle-5"></div>
                    <div class="circle-6"></div>
                </div>
            </div>
            <div id="verfahren" class="row">
                <div>
                    <h1 class="verfahrenh1">ドイツに留学するまでにやること</h1>
                </div>
                <div class="row es">
                    <div class="offset-md-1 col-md-2">
                        <a href="#sprachdiv"><img src="200930sprach.png" alt="sprach" height="200" width="200" class="sprach_image"></a>ドイツ語の習得
                    </div>
                    <div class="col-md-2">
                        <a href="./"><img src="200930visa.png" alt="visa" height="200" width="200" class="visa_image"></a>ビザ取得
                    </div>
                    <div class="col-md-2">
                        <a href="./"><img src="200930schule.png" alt="schule" height="200" width="200" class="schule_image"></a>志望大学・教育機関の決定
                    </div>
                    <p class="mussen-p">→</p>
                    <div class="col-md-2">
                        <a href="./"><img src="200930bewerbung.png" alt="bewerbung" height="200" width="200" class="bewerbung_image"></a>申し込み・ビザ取得<br>
                    </div>    
                    <p class="mussen-p">→</p>
                    <div class="col-md-2">
                        <a href="./"><img src="201005zulassung.png" alt="zulassung" height="200" width="200" class="zulassung_image"></a>入学
                    </div>    
                </div>
            </div>
            <div id="sprachdiv" class="row">
                <h1 class="offset-md-2 col-md-10 sprachtesth1">語学力を証明しよう</h1>
                <p class="offset-md-2 col-md-10 sprachtestp">
                    ドイツの教育機関で学ぶためにはほどんどの場合自身のドイツ語の能力を証明する必要があります。<br>
                    ドイツ語力を証明するための試験はいくつかあるのですが、その中でも代表的な試験を４つご紹介します！
                </p>
            </div>
            <div class="row">
                <a class="offset-md-1 col-md-2 tab_btn is-active-btn" section="#item1">DSH</a>
                <a class="col-md-3 tab_btn" section="#item2">TestDaf</a>
                <a class="col-md-3 tab_btn" section="#item3">Telc C1 Hochschule</a>
                <a class="col-md-2 tab_btn" section="#item4">Goethe</a>
            </div>
            <div class="row">
                <div class="col-md-12 tab_item is-active-item" id="item1">
                    <div class="row">
                        <div class="offset-md-1 col-md-4 foto-DSH">
                            <a class="foto-DSHa" href="./"><img src="200927foto-DSH.jpg" alt="foto-DSH" height="150" width="300"></a>
                        </div>
                        <div class="col-md-7">
                            <ul class="float-right">
                                <li class="DSHli">DSHの特徴</li>
                                <p class="DSHtext">
                                    ドイツの大学入学を目指す外国人向けの語学試験です。
                                    各大学が主催し作成しているためドイツ国内でしか受験できず、難易度にばらつきがあります。
                                    対策も各試験の過去問ホームぺジからダウンロードしそれぞれ行わなければなりません。
                                    合格すれば一定のドイツ語能力を示せるので、受験した大学だけでなくドイツ全国の大学に応募することができます。
                                    向き不向きがあるので一概には言えませんが大抵の場合TestDafなど他の語学試験に比べてDSH試験は難易度が低くく、
                                    受験料は80€程度で比較的安く受験できます。
                                    試験は２日に分けられており、読解・聴解・筆記に合格した人のみ違う日に開催される口頭試験を受けられるようです。
                                    結果も一週間以内にわかる場合がほとんどです。
                                    デメリットとして年に各大学で１、２回しか開催されておらず、外部受験だと定員がすぐに埋まってしまって受験しにくい点があります。
                                    大学の語学準備コースなど、卒業試験としてDSHを受けられる公立の語学学校でしっかりと対策をしつつ受験することをおすすめします。
                                    またDSH試験を受験できる私立の語学学校だとC1コースの授業料とDSH試験の受験料合わせて1000€近くかかることもありますし、
                                    DSH試験を受験できない大学の語学準備コースもあるので注意しなければなりません。<br>
                                    私の感覚ではこのDSH試験で語学証明をして入学した外国人が一番多いと思います。
                                </p>
                                <li class="DSHli">試験の構成</li>
                                <h4 class="DSHtext2">
                                    筆記試験（一次試験）
                                </h4>
                                <ul class="DSHtext3">
                                    <li class="li-DSH-struktur">Leseverstehen(読解)</li>
                                    <li class="li-DSH-struktur">Hörverstehen(聞き取り)</li>
                                    <li class="li-DSH-struktur">Textproduktion(作文)</li>
                                    <li class="li-DSH-struktur">Wissenschaftssprachliche Strukturen(文法問題)</li>
                                </ul>
                                <br>
                                <h4 class="DSHtext2">
                                    口頭試験（二次試験）
                                </h4>
                                <ul class="DSHtext4">
                                    <li class="li-DSH-struktur">自己紹介・大学の志望動機・テストを受けた感想</li>
                                    <li class="li-DSH-struktur">専門分野に関連する文章の要約と質疑応答・事前に渡される15行程度の記事に対する質疑応答など</li>
                                </ul>
                                <li class="DSHli">合格基準</li>
                                <p>筆記試験、口述試験共に57％以上正答した場合が合格とされます。 57％以上の合格者は、筆記＋口述の正答率によって次の3段階評価が与えられます。</p>
                                <ul class="DSHtext5">
                                    <li class="li-DSH-bestehen">DSH1 (57％〜66%) 音楽など芸術系の学部には応募できることもあります</li>
                                    <li class="li-DSH-bestehen">DSH2 (67％〜81%)　大抵の学部に応募できます</li>
                                    <li class="li-DSH-bestehen">DSH3 (82％〜100%)　医学部を含む全ての学部に応募できます</li>
                                </ul>
                            </ul>    
                        </div>    
                    </div>        
                </div>
                <div class="col-md-12 tab_item" id="item2">
                    <div class="row">
                        <div class="offset-md-1 col-md-4 foto-DSH">
                            <a class="foto-DSHa" href="./"><img src="201002testdaf.jpg" alt="foto-testdaf" height="300" width="300"></a>
                        </div>
                        <div class="col-md-7">
                            <ul class="float-right">
                                <li class="testdafli">TestDafの特徴</li>
                                <p class="testdaftext">
                                    TestDaFとは、ドイツ語能力を証明するための語学能力試験で、ドイツの大学応募時に必要なドイツ語能力証明書だけでなく、就職活動にも有効な試験です。
                                    年に５、６回様々な語学学校で同じ日に開催されています。人気なテストで受験資格も先着順なので定員オーバーになることが多くありますが、
                                    申し込み開始日の開始時間に申し込めば大抵の場合受験資格をもらうことができるのでそも日は戦いのつもりで頑張りましょう！
                                    日本でも年に２回ほど獨協大学や東京のGoethe-Institutで受験できます。受験料は190€前後です。
                                    一度合格すると語学証明として一生使うことができますが、
                                    結果がわかるまでに６週間以上かかります。　DSH試験の次に多くの外国人が受験している印象です。
                                </p>
                                <li class="testdafli">試験の構成</li>
                                <ul class="testdaftext3">
                                    <li class="li-DSH-struktur">Leseverstehen(読解)　60分</li>
                                    <li class="li-DSH-struktur">Hörverstehen(聞き取り)　3問</li>
                                    <li class="li-DSH-struktur">Textproduktion(作文)　60分</li>
                                    <li class="li-DSH-struktur">mündlicher Ausdruck (口頭試験) 7問</li><br>
                                    <p>
                                        口頭試験はコンピュータで行われます。大抵の場合マイク付きのヘットフォンをして録音する形で周りの人と一斉に話始めるため、
                                        自分の世界に入って、周りの人を気にしない心の強さと準備が大切です。特に問４と問６！
                                    </p>
                                </ul>
                                <br>
                                <li class="testdafli">合格基準</li>
                                <p></p>
                                <ul class="DSHtext5">
                                    <li class="li-DSH-bestehen">TDN3 音楽など芸術系の学部、専門学校には応募できることもあります</li>
                                    <li class="li-DSH-bestehen">TDN4 大抵の学部に応募できます</li>
                                    <li class="li-DSH-bestehen">TDN5 医学部を含む全ての学部に応募できます</li>
                                </ul>
                                <p>
                                    <p><例></p>
                                    <ul class="testdaftext6">
                                    <li class="li-DSH-struktur">Leseverstehen(読解)　3</li>
                                    <li class="li-DSH-struktur">Hörverstehen(聞き取り)　4</li>
                                    <li class="li-DSH-struktur">Textproduktion(作文)　4</li>
                                    <li class="li-DSH-struktur">mündlicher Ausdruck (口頭試験) 5</li></ul><br>
                                    のようにそれぞれの科目で結果が出ます。大抵の総合大学では「全ての科目で４以上」が求められていますが、
                                    感覚で３割の総合大学では「合計１６」などという出願基準もありますので大学のHPを見てください。
                                </p>
                            </ul>    
                        </div>    
                    </div>        
                </div>
                <div class="col-md-12 tab_item" id="item3">
                    <div class="row">
                        <div class="offset-md-1 col-md-4 foto-DSH">
                            <a class="foto-DSHa" href="./"><img src="201005telc.jpeg" alt="foto-telc" height="400" width="300"></a>
                        </div>
                        <div class="col-md-7">
                            <ul class="float-right">
                                <li class="telcli">Telc C1 Hochschuleの特徴</li>
                                <p class="telctext">
                                    Telc C1 Hochschuleは大学入学に有効な語学試験です。他にもTelcではA1からC2までのレベルの試験があり大学入学用、医学部用、移民の語学証明用、
                                    仕事や就職活動用など全部で約25種類の試験があるので目的に合った試験を受けることができます。ドイツ各地の語学学校で受験でき、多い学校
                                    では年に１２回ほど開催されるので受験資格がもらえやすいのが特徴です。受験料は語学学校によって違いますが大体200€程度で、合否は６週間〜８週間で
                                    判明します。学校によっては追加で80€程度払えば２週間〜４週間で結果を送ってくれるので、大学申し込み期限ギリギリの人は活用は良い選択肢の一つになるでしょう。
                                    まだ新しいテストという認識はありますが、受験しやすいという点で認知度も上がり人気が出てきている試験です。
                                    また、筆記試験または口頭試験に一度合格すれば、次回からは合格した科目は受験しなくてもよく不合格だった方だけを何度も受けることができるので
                                    次回の負担を軽くすることができます。
                                    いろいろな意見がありますが、DSHやTestdafに比べて一番Telcが難しいと思います。読解が特に難しく多くの語彙が必要で虫食いテストの文法問題があります。
                                    聞き取りは全て選択問題なので、話すのや感覚でドイツ語を使うのが苦手な、ずっとドイツ語の講義を受けて机に向かって勉強しけきた系の日本人はTestdafよりもTelcの方が向いているかもしれません。
                                    あくまで私の肌感覚ですのでご自身で最終判断してください！！
                                <li class="telcli">試験の構成</li>
                                <ul class="telctext3">
                                    <li class="li-DSH-struktur">Leseverstehen(読解)　90分</li>
                                    <li class="li-DSH-struktur">Hörverstehen(聞き取り)　40分</li>
                                    <li class="li-DSH-struktur">Textproduktion(作文)　70分</li>
                                    <li class="li-DSH-struktur">mündlicher Ausdruck (口頭試験) 16分〜24分</li><br>
                                    <p>
                                        口頭試験は受験者の中で二人組にを指定されて、まずは簡単な自己紹介をし、相手に２分間のプレゼンをします。
                                        内容はある事柄に対しての長所と短所だったり問題点と解決策だったり様々です。
                                        プレゼンを聞いてもう一人の人は内容を要約します。
                                        それから、ことわざや名言が書いてある紙を渡されて二人で言葉に対しての解釈や意見を議論します。
                                    </p>
                                </ul>
                                <br>
                                <li class="testdafli">合格基準</li>
                                <p></p>
                                <ul class="DSHtext5">
                                    <li class="li-DSH-bestehen">筆記試験（読解、聞き取り、作文）：60%以上</li>
                                    <li class="li-DSH-bestehen">口頭試験　：　60%以上</li>
                                </ul>
                                <p>
                                    筆記試験は読解、聞き取り、作文の３つの領域の平均で60%以上取れば良いので、例えば、読解90%・聞き取り40%
                                    ・作文60%でも平均で63%なので筆記試験合格になります。
                                </p>
                            </ul>    
                        </div>    
                    </div>        
                </div>
                <div class="col-md-12 tab_item" id="item4">
                    <div class="row">
                        <div class="offset-md-1 col-md-4 foto-DSH">
                            <a class="foto-DSHa" href="./"><img src="201005goethe.png" alt="foto-goethe" height="300" width="300"></a>
                        </div>
                        <div class="col-md-7">
                            <ul class="float-right">
                                <li class="goetheli">Goetheの特徴</li>
                                <p class="goethetext">
                                    このテストはあらゆる場所で有効な国際的なテストです。
                                    CEFRと言ってヨーロッパ全体で外国語の学習者の習得状況を示す際に用いられるガイドラインに則りテストが作られています。
                                    レベルはA1・A2・B1・B2・C1・C2の6つに別れていていますので自身のドイツ語力を証明したり、
                                    ドイツ語を学習している途中でドイツ語習得のモチベーションのための目標設定としておすすめのテストです。
                                    芸術系ではない普通の学部に進学したい場合、ゲーテのC2を求める大学が多いので大学入学のための語学証明としては受験する人は少ない印象です。
                                    日本でも受験でき、年に２回大阪と東京で受験できます。
                                <li class="telcli">試験の構成</li>
                                <ul class="telctext3">
                                    <li class="li-DSH-struktur">Leseverstehen(読解)　70分</li>
                                    <li class="li-DSH-struktur">Hörverstehen(聞き取り)　40分</li>
                                    <li class="li-DSH-struktur">Textproduktion(作文)　80分</li>
                                    <li class="li-DSH-struktur">mündlicher Ausdruck (口頭試験) 10分程度</li><br>
                                </ul>
                                <br>
                                <li class="goetheli">合格基準</li>
                                <p>
                                    全ての科目で60%以上正解する必要があります。
                                </p>
                            </ul>    
                        </div>    
                    </div>        
                </div>
            </div>
            <div class="row ttest">
                <div class="offset-md-1 col-md-4">
                    <div class="offset-md-1 testli">
                        開催日時と申し込み
                    </div>
                    <form>
                    	<div class="search-box">
                    		<span class="search-box_label"><テストの種類></span><br>
                    		<input type="radio" name="kind" value="">ALL
                    		<input type="radio" name="kind" value="DSH">DSH
                    		<input type="radio" name="kind" value="TestDaF">TestDaF
                    		<input type="radio" name="kind" value="Telc">Telc
                    		<input type="radio" name="kind" value="Goethe ">Goethe
                    	</div>
                    
                    	<div class="search-box">
                    		<span class="search-box_label"><筆記試験日> 2021年</span><br>
                    		<input type="checkbox" name="wann" value="">ALL
                    		<input type="checkbox" name="wann" value="1月">1月
                    		<input type="checkbox" name="wann" value="2月">2月
                    		<input type="checkbox" name="wann" value="3月">3月
                    		<input type="checkbox" name="wann" value="4月">4月
                    		<input type="checkbox" name="wann" value="5月">5月
                    		<input type="checkbox" name="wann" value="6月">6月<br>
                    		<input type="checkbox" name="wann" value="7月">7月
                    		<input type="checkbox" name="wann" value="8月">8月
                    		<input type="checkbox" name="wann" value="9月">9月
                    		<input type="checkbox" name="wann" value="10月">10月
                    		<input type="checkbox" name="wann" value="11月">11月
                    		<input type="checkbox" name="wann" value="12月">12月
                    	</div>
                    	<div class="search-box">
                    		<span class="search-box_label"><場所></span><br>
                    		<input type="checkbox" name="wo" value="">ALL<br>
                    		<input type="checkbox" name="wo" value="Baden-Württemberg">Baden-Württemberg<br>
                    		<input type="checkbox" name="wo" value="Bayern">Bayern<br>
                    		<input type="checkbox" name="wo" value="Berlin">Berlin<br>
                    		<input type="checkbox" name="wo" value="Brandenburg">Brandenburg<br>
                    		<input type="checkbox" name="wo" value="Bremen">Bremen<br>
                    		<input type="checkbox" name="wo" value="Hamburg">Hamburg<br>
                    		<input type="checkbox" name="wo" value="Hessen">Hessen<br>
                    		<input type="checkbox" name="wo" value="Mecklenburg-Vorpommern">Mecklenburg-Vorpommern<br>
                    		<input type="checkbox" name="wo" value="Niedersachsen">Niedersachsen<br>
                    		<input type="checkbox" name="wo" value="Nordrhein-Westfalen">Nordrhein-Westfalen<br>
                    		<input type="checkbox" name="wo" value="Rheinland-Pfalz">Rheinland-Pfalz<br>
                    		<input type="checkbox" name="wo" value="Saarland">Saarland<br>
                    		<input type="checkbox" name="wo" value="Sachsen">Sachsen<br>
                    		<input type="checkbox" name="wo" value="Sachsen-Anhalt">Sachsen-Anhalt<br>
                    		<input type="checkbox" name="wo" value="Schleswig-Holstein">Schleswig-Holstein<br>
                    		<input type="checkbox" name="wo" value="Thüringen">Thüringen<br>
                    	</div>
                    </form>
                </div>
                <div class="col-md-7">
                    <ul class="list">
                        <?php foreach($prufungen as $prufung){ ?>
                            <li class="list_item" data-kind="<?php print $prufung['art']; ?>" data-wann="<?php print (str_replace("0", "", substr($prufung['tag'], 3, 2)) . "月"); ?>" data-wo="<?php print $prufung['land']; ?>"><a href="<?php print $prufung['url']; ?>" target="_blank"><?php print $prufung['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10 mt-3">
                    <h1 class="text-center maph1">試験会場一覧</h1>
                </div>
                <div class="col-sm-2 mt-4">
                    <a href="new.php" class="btn btn-primary">新規試験情報登録</a>
                </div>
            </div>
            <div class="row mt-3">
                <table class="col-sm-12 table">
                    <tr>
                        <td><div id="target"></div></td>
                        <td><div id="sidebar"></div></td>
                    </tr>
                </table>
            </div>
           
            <div id="visum"class="row visum">
                <div class="offset-md-1 col-md-10 visumerk">
                    <h1>滞在許可（ビザ）を取得しよう</h1>
                    <h6>ドイツに９０日以上滞在する場合は滞在許可が必要です。<br>
                    今回はドイツで学びたい人がよく使うビザを４つご紹介します。市によって、担当者によって、なんなら担当者の気分によって細かい基準が変わるので注意しましょう。
                    ビサを取得するためにまず住民登録、銀行口座開設、保険加入する必要があります</h6>
                </div>
                <div class="offset-md-1 col-md-5 visum1">
                    <h3 class="visumtitel">1.語学学生ビザ</h3>
                    <p class="visump">所定の授業数のドイツ語コースを履修することを前提としたビザで、入学許可証など語学学校に在籍していることを証明する必要があります。
                        <ul class="visumul">
                            <li>申請場所：ドイツ</li>
                            <li>就労：×</li>
                            <li>年齢制限：×</li>
                            <li>期間：最長２年</li>
                            <li>経済力証明: ドイツの閉鎖口座（Sperrkonto、１年で8,640€）</li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-5 visum2">
                    <h3 class="visumtitel">2.学生準備ビザ</h3>
                    <p class="visump">大学入学を目的としたドイツでの準備期間に支給されるビザで、所定の授業数のドイツ語コースを履修することが必要です。
                        <ul class="visumul">
                            <li>申請場所：ドイツ</li>
                            <li>就労：○（月に４５０€以下や語学学校が長期休暇の時のみという制限付き）</li>
                            <li>年齢制限：×</li>
                            <li>期間：最長２年</li>
                            <li>経済力証明: ドイツの閉鎖口座（Sperrkonto、１年で8,640€）</li>
                        </ul>
                    </p>
                </div>
                <div class="offset-md-1 col-md-5 visum3">
                    <h3 class="visumtitel">3.学生ビザ</h3>
                    <p class="visump">大学に通う人のビザで、大学や大学院の入学許可証や在籍許可証が必要です。
                        <ul class="visumul">
                            <li>申請場所：ドイツ</li>
                            <li>就労：○（月に４５０€以下などの制限付き）</li>
                            <li>年齢制限：×</li>
                            <li>期間：大学の在籍期間は受給でき、1,2年に１回に更新しなければならない</li>
                            <li>経済力証明: ドイツの閉鎖口座（Sperrkonto、１年で8,640€）</li>
                        </ul>
                    </p>
                </div>
                <div class="col-md-5 visum4">
                    <h3 class="visumtitel">4.ワーキングホリデービザ</h3>
                    <p  class="visump">ドイツで働いたり勉強したり、いろいろな経験をまずはしたい方はこのビザ！
                        <ul class="visumul">
                            <li>申請場所：ドイツ&日本</li>
                            <li>就労：○（一つの職場での最長就労期間は6ヶ月）</li>
                            <li>年齢制限：18歳〜30歳まで</li>
                            <li>期間：３ヶ月間〜１年</li>
                            <li>経済力証明: ２０００€（日本の口座でも可能）</li>
                        </ul>
                    </p>
                </div>
            </div>
            <div class="row mt-2" id="fragens">
                <div class="col-md-12 text-center">
                    <h2>質問コーナー</h2>
                </div>    
            </div>
            <div class="row tabel">
                <!--<div class="row">-->
                <!--<div class="offset-md-1">-->
                <!--    <a href="new.php" class="btn btn-primary">新規投稿</a>-->
                <!--</div>-->
                <!--<div class=" mt-2">-->
                <form class=" offset-md-1 col-md-4" action="index.php" method="POST" enctype="multipart/form-data">
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">名前</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">メールアドレス</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="email" required>
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">質問</label>
                        <div class="col-10">
                            <input type="text" class="form-control" name="fragen" required>
                        </div>
                    </div>
                    
                    <!-- 1行 -->
                    <div id="frage" class="form-group row">
                        <div class="offset-2 col-10">
                            <button type="submit" class="btn btn-primary">投稿</button>
                        </div>
                    </div>
                </form>
                <div class="col-md-7">
                    <?php if(count($fragens) !== 0){ ?> 
                        <table class="offset-md-1 col-md-10 table table-bordered table-striped">
                            <tr>
                                <th>名前</th>
                                <th>質問</th>
                                <th>答え</th>
                                <th></th>
                            </tr>
                        <?php foreach($fragens as $fragen){ ?>
                            <tr>
                                <td><?php print $fragen['name']; ?></td>
                                <td><?php print $fragen['fragen']; ?></td>
                                <td><?php print $fragen['antwort']; ?></td>
                                <td><a href="show.php?id=<?php print $fragen['id'] ?>">答える</a></td>
                            </tr>
                        <?php } ?>
                        </table>
                    <?php }else{ ?>
                            <p>データ一件もありません。</p>
                    <?php } ?>
                </div>    
            </div>
        </div>
         <!-- MarkerCluster -->
            <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
            <!--Google MAP API KEY -->
            <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyALg70uaMcYjkzto9oPmiXyODIXCvpvAzg&callback=initMap" async defer></script>
           
    </body>
</html>