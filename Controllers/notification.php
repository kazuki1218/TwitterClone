<?php

// ノーティフィケーションコントローラー

// 設定の読み込み
include_once '../config.php';

// 便利な関数の読み込み
include_once '../util.php';

//ツイートデータ操作モデルを読み込む
include_once '../Models/notifications.php';

// ログインチェック
$user = getUserSession();
if (!$user) {
    // ログインしていない場合
    header('Location: ' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 表示用の変数
$view_user = $user;

//通知一覧
$view_notifications = findNotifications($user['id']);

// 画面表示
include_once '../Views/notification.php';


