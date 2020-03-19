$(document).ready(function()
{
    console.log("this is test");
    // Topicsc のレコードを取得（success、error で処理）
    $('#change-topics-success').change(function(e){
        // Selectボックスの値を取得
        var select_number = $('[name=select_number_success] option:selected').val();
        // 取得した値をアラートで表示（デバッグ用）
        alert( select_number );

        // CSRF対策用の CSRFトークンの値を取得
        var csrf = $('input[name=_csrfToken]').val();

        $.ajax({
            type: "POST",
            datatype:'JSON',
            // 処理をする Ajaxの URLを指定。自サーバ内であればドキュメントルートからのパスでも OK
//          url: "/cake3_9/ajax-samples/replace_index_area",
            url: "http://localhost:8099/cake3_9/ajax-samples/replace_index_area",
            // CakePHP に送る値を指定（「:」の前が CakePHPで受け取る変数名。後ろがこの js内の変数名。）
            data: {
                "select_number" : select_number,
            },

            // beforeSend を利用して CSRFトークンのチェックを実行
            beforeSend: function(xhr){
                 xhr.setRequestHeader("X-CSRF-Token",csrf);
            },

            // 正常に処理が実行された場合は、1つ目のパラメータに取得した HTMLが返ってくる
            success: function(html, status, xhr){
                // 返ってきた HTMLを置換
                $("div#index-area-success").replaceWith(html);
                // 返ってきたステータスコードなどをアラートで表示（デバッグ用）
                alert('Success\n' + status + "\n" + xhr.status + "\n" + xhr.statusText );
            },

            // 正常に処理が行われなかった場合の処理
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                // 返ってきたステータスコードなどをアラートで表示（デバッグ用）
                alert('Error : ' + errorThrown + "\n" +
                    XMLHttpRequest.status + "\n" +
                    XMLHttpRequest.statusText + "\n" +
                    textStatus );
            }
         });
    });

    // Topicsc のレコードを取得（then で処理）
    $('#change-topics-then').change(function(e){
        var select_number = $('[name=select_number_then] option:selected').val();
        alert( select_number );

        var csrf = $('input[name=_csrfToken]').val();

        $.ajax({
            type: "POST",
            datatype: 'JSON',
            url: "http://localhost:8099/cake3_9/ajax-samples/replace_index_area",
            data: {
                "select_number": select_number,
                "template_type": "index-area-then",
            },
            beforeSend: function(xhr){
                xhr.setRequestHeader("X-CSRF-Token",csrf);
            }
        })
        .then(
            // 正常に処理が実行された場合は、1つ目のパラメータに取得した HTMLが返ってくる
            function(html, status, xhr){
                $("div#index-area-then").replaceWith(html);
                alert('Success\n' + status + "\n" + xhr.status + "\n" + xhr.statusText );
            },

            // 正常に処理が行われなかった場合の処理
            function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown + "\n" +
                    XMLHttpRequest.status + "\n" +
                    XMLHttpRequest.statusText + "\n" +
                    textStatus );
            }
        );
    });
});