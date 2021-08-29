<?php
//エラー表示あり
ini_set('display_errors',1);
//日本時間にする
date_default_timezone_set('Asia/TOkyo');
//URL/ディレクトリ設定
define('HOME_URL', 'http://localhost/TwitterClone/');
// ('/TwitterClone/')だけでもよい
// データベースの接続情報
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'twitter_clone');
