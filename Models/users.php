<?php

// ユーザーデータを処理

/**
 * ユーザーの作成
 *
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    //  DBの接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    //  接続エラーががある場合 -> 処理停止
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。: ' . $mysqli->connect_error . "\n";
        exit;
    }

    // 新規登録のSQLクエリを作成
    $query = 'INSERT INTO users (email, name, nickname, password) VALUES (?, ?, ?, ?)';

    // プリペアドステートメントに、作成したクエリを登録
    $statement = $mysqli->prepare($query);

    // パスワードをハッシュ値に変換
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    // クエリのプレースホルダ(？の部分)にカラム値を紐付け
    $statement->bind_param('ssss', $data['email'], $data['name'], $data['nickname'], $data['password'],);

    // クエリの実行
    $response = $statement->execute();

    // 実行に失敗した場合 -> エラーの表示
    if ($response === false) {
        echo 'エラーメッセージ : ' . $mysqli->error . "\n";
    }

    // DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;
}

/**
 * ユーザー情報取得　 : ログインチェック
 *
 * @peram string $email
 * @peram string $password
 * @return array|false
 */
function findUserAndCheckPassword(string $email, string $password)
{
    //  DBの接続
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    //  接続エラーががある場合 -> 処理停止
    if ($mysqli->connect_errno) {
        echo 'MySQLの接続に失敗しました。: ' . $mysqli->connect_error . "\n";
        exit;
    }

    // 入力値をエスケープ
    $email = $mysqli->real_escape_string($email);

    // SQLクエリの作成
    // - 外部からのリクエストは何が入ってくるかわからないので、必ず、エスケープしたものをクオートで囲む
    $query = 'SELECT * FROM users WHERE email = "'.$email.'"';

    // クエリの実行
    $result = $mysqli->query($query);

    // クエリの実行に失敗した場合->return
    if (!$result) {
        // MySQL処理中にエラー発生
        echo 'エラーメッセージ: ' . $mysqli->error . "\n";
        $mysqli->close();
        return false;
    }

    // ユーザー情報を取得
    $user = $result->fetch_array(MYSQLI_ASSOC);
    // ユーザーが存在しない場合->return
    if (!$user) {
        $mysqli->close();
        return false;
    }

    // パスワードチェック、不一致の場合->return
    if (!password_verify($password, $user['password'])) {
        $mysqli->close();
        return false;
    }

    // DB接続を解放
    $mysqli->close();

    return $user;
}
