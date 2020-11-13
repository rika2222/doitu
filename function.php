function dbConnect(){
  $db = parse_url($_SERVER[' mysql://bca9c6ea51e0fc:86030753@eu-cdbr-west-03.cleardb.net/heroku_932d18c23319b85?reconnect=true']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $user = $db['user'];
  $password = $db['pass'];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY =>true,
  );
  $dbh = new PDO($dsn,$user,$password,$options);
  return $dbh;
}