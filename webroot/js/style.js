
/* 開始時間が変更されたら */
function autoPlus(s) {
	document.iptfrm.time_end.selectedIndex = s.selectedIndex;
}
/* キー無しの削除確認 */
function dltChk() {
	var flag = confirm ( "削除します。よろしいですか？");
	return flag; /* flag が TRUEなら送信、FALSEなら送信しない */
}

$(function(){
    $('.dropdown li').hover(function(){
        $("ul:not(:animated)", this).slideDown();
    }, function(){
        $("ul.dropdown-menu",this).slideUp();
    });

    $('#reservation').submit(function() {
        var start_time = $('#start_time').val(),
            end_time   = $('#end_time').val(),
            purpose    = $('#purpose').val(),
            kwd        = $('#kwd').val();
        var message = '';
        if (start_time == '') {
            message += '開始時間,'
        }
        if (end_time == '') {
            message += '終了時間,'
        }
        if (purpose == '') {
            message += '目的,'
        }
        if (kwd == '') {
            message += '秘密鍵,'
        }
        if (message != '') {
            message += 'を入力してください'
        }
        if (message != '') {
            alert(message);
            return false;
        }
      //  var start_time = document.getElementById()
    });
});