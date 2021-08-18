///////////////////////////////////////
// いいね！用のJavaScript
///////////////////////////////////////
$(function(){
    // いいね！がクリックされた時
    $('.js-like').click(function(){
        const this_obj = $(this); //クリックされた時
        const like_id = $(this).data('like-id'); //クリックされた時('like-id')の数が入ります。
        const like_conut_obj = $(this).parent().find('.js-like-count');
        let like_count = Number(like_conut_obj.html());

        if(like_id){
            //いいねの取り消し
            //いいね！いいね！カウントを減らす
            like_count--;
            like_conut_obj.html(like_count);
            this_obj.data('like-id', null);

            //いいね！いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src','../Views/img/icon-heart.svg');
        } else{
            //いいねを付与
            //いいね！いいね！カウントを増やす
            like_count++;
            like_conut_obj.html(like_count);
            this_obj.data('like-id', true);

            //いいね！いいね！ボタンの色を青に変更
            $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');
        }
    });
})