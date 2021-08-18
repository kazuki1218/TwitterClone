<?php

///////////////////////////////////////
// 便利な関数
///////////////////////////////////////

/**
    * 画像ファイル名から画像のURLを生成
    *
    * @param string $name 画像ファイル名
    * @param string $type ユーザー画像かツイート画像
    * @return string
    */
function buildImagePath(string $name = null, string $type)
{
    if ($type === 'user' && !isset($name)) {
        // ファイルが存在しない場合はデフォルトの画像を返す処理。
        return HOME_URL . 'Views/img/icon-default-user.svg';
    }

    return HOME_URL . 'Views/img_uploaded/' . $type . '/' . htmlspecialchars($name);
}

/**
    * 指定した日時からどれだけ経過したかを取得
    *
    * @param string $datetime 日時
    * @return string
    */
function convertToDayTimeAgo(string $datetime)
{
    $unix = strtotime($datetime);
    $now = time();
    $diff_sec = $now - $unix;

        // １分前であれば、〇〇秒前
    if ($diff_sec < 60) {
        $time = $diff_sec;
        $unit = '秒前';
        // １時間前であれば、〇〇分前
    } elseif ($diff_sec < 3600) {
        $time = $diff_sec / 60;
        $unit = '分前';
        // ２４時間前であれば、〇〇時間前
    } elseif ($diff_sec < 86400) {
        $time = $diff_sec / 3600;
        $unit = '時間前';
        // 32日前であれば、〇〇日前
    } elseif ($diff_sec < 2764800) {
        $time = $diff_sec / 86400;
        $unit = '日前';
    } else {
        if (date('Y') != date('Y', $unix)) {
            // 現在の日時から投稿日時の年が違う場合は、年月日を返す。
            $time = date('Y年n月j日', $unix);
        } else {
            // 現在の日時から投稿日時が同じ年の場合は、月日を返す。
            $time = date('n月j日', $unix);
        }
        return $time;
    }

    return (int)$time . $unit;
}

