<!-- 予約フォーム（年月日から入れるもの -->

<?php


$templateStart = array(
        'type' => 'datetime',
        'label' => '',
        'dateFormat' => 'YMD',
        'monthNames' => false,

        'separator' => '-',
        'minYear' => date('Y'),
        'maxYear' => date('Y')+1,
        'default' => date('Y-m-d h:i'),
        'interval' => 30

);
$templateEnd = array(
    'type' => 'datetime',
    'label' => '',
    'dateFormat' => 'YMD',
    'monthNames' => false,
    'separator' => '-',
    'minYear' => date('Y'),
    'maxYear' => date('Y')+1,

    'default' => date('Y-m-d h:i'),
    'interval' => 30
);

?>

<!-- <h2>予約フォーム</h2>
<p>※秘密鍵は任意です</p>-->
<div class="form">
    <?php 
    // // ラジオボタン用のデータ作成
    // $options = [];
    // $conut = 1;
    // foreach ($rooms as $room) {
    //     $option[$conut] = $room->name;
    //     $conut++;
    // }
    // echo "<table>";
    // echo $this->Form->create('reservations');
    // echo $this->Form->hidden('user_id',['value' => $id]);
    // echo "<tr>";
    //     echo "<th>使う部屋：</th>";
    //     echo "<td>";
    //         echo $this->Form->radio('room_id', ['options' => $rooms]);
    // echo "</td></tr>";
    // echo "<tr><th>";
    //     echo "開始時間：";
    // echo "</th><td>";
    //     echo $this->Form->input('start_time',$templateStart);
    // echo "</td></tr>";
    // echo "<tr><th>";
    //     echo "終了時間：";
    // echo "</th><td>";
    //     echo $this->Form->input('end_time',$templateEnd);
    // echo "</td></tr>";
    // echo "<tr><th>目的：</th><td>";
    //     echo $this->Form->input('purpose',['label' => '']);
    // echo "</td></tr>";
    // echo "<tr><th>";
    //     echo "秘密鍵：";
    // echo "</th><td>";
    //     echo $this->Form->input('key', ['label' => '']) . "</td></tr>";
    // echo "<tr><td></td><td></td><td>";
    // echo $this->Form->button('予約する');
    // echo "</td></tr>";
    // echo $this->Form->end();

    // echo "</table>";
    ?>
</div>

<!doctype html>
<html> 
<head>
    <title>計算ソフト</title>
    <meta charset="UTF-8">
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<style>
table{
    text-align : center ;
    margin : 20px ; 
}
td{
    width :50px;
    padding : 10px;
}
th span{
    white-space: nowrap;
}
#result2{
    margin :20px;
    font-weight:  bold;
}
form{
    clear : both;
    width : 500px
}
#canvas{
    margin-left : 50px;
    padding : 50px
}
</style>
<body>
    <div>
        <h1>１辺がx,１辺がy,1辺がzの立方体の体積は？</h1>
        <form>
            x=
            <input type="text" id="num31">
            <select id="num1">
                <option  value="0">整数</option>
                <option  value="1">平方根</option>
            </select><br />
            y=
            <input type="text" id="num32">
            <select id="num2">
                <option id="int" value="0">整数</option>
                <option id="arg" value="1">平方根</option>
            </select><br />
            z=
            <input type="text" id="num33">
            <select id="num3">
                <option id="int" value="0">整数</option>
                <option id="arg" value="1">平方根</option>
            </select>
            <input type="button" id="btn3" value="計算する">
        </form>
        <div id="result2"></div>
        <div id="result1"></div>
            
            <canvas id="canvas" width="200" height="200"></canvas>
    <script>
            $(function() {
                //計算するを押すと動く関数
                $('#btn3').click(function(){
                    document.getElementById('result1').innerHTML="";
                    var num=[];
                    //送られてきた値を取得
                    var x = document.getElementById('num31').value;
                    var y = document.getElementById('num32').value;
                    var z = document.getElementById('num33').value;
                    
                    //空の時、エラーで返すvalidate
                    if(x==null || y==null || z==null) {
                         document.getElementById('result1').innerHTML="半角数字を入力してください";

                         //半角数字かどうか判別
                    } else if((!isNaN(x) && !isNaN(y)) && !isNaN(z)){

                        //整数かどうか取得
                        var con1 = document.getElementById('num1').value;
                        var con2 = document.getElementById('num2').value;
                        var con3 = document.getElementById('num3').value;
                        //上で取得したもので場合分け
                        if(con1==1) {
                            x = Math.sqrt(x);
                        }
                        if(con2==1){
                            y = Math.sqrt(y);
                        }
                        if(con3==1){    
                            z = Math.sqrt(z);
                        }

                        //文字列を数字に変化する,,,  最初に書けば全角もいける？
                        num['x'] = Number(x);
                        num['y'] = Number(y);
                        num['z'] = Number(z);
                        console.log(num);
                        var V = 1
                        for(var i in num){
                            V *= num[i]
                        }
                        console.log(V);
                        
                        //小数第一位を四捨五入
                        var V2 =Math.round(V*10)/10;
                        console.log(V);
                        
                        //表の作成
                        document.getElementById('result1').innerHTML='<table border="1"><th>x</th><th>y</th><th>z</th>'
    +'<th><span>体積（四捨五入)</span></th><tr><td>' + x + '</td><td>' + y + '</td><td>' + z + '</td><td>'
    + V2 + '</td></tr></table>'
    
                        document.getElementById('result2').innerHTML= '途中式<br />V = ' +  x  + ' × ' + y  + ' × ' + z 
                    
                        //半角数字出ない時
                    }else{

                        document.getElementById('result1').innerHTML="半角数字を入力してください";
                    };

                    //図形の補正
                    if(V <=7){
                        x = x *50;
                        y = y *50;
                        z = z *50;
                    }
                    
                    //図形の作成に入る
                    
                    var camvas_width = 200;     // camvas の高さを設定する。
                    var camvas_height= 200;     // camvas の幅を設定する。

                    const coord = [ // 座標
                        [0, 0, 0],
                        [ x, 0, 0],
                        [ 0, y, 0],
                        [ x, y, 0],
                        [0, 0, z],
                        [ x, 0, z],
                        [0, y, z],
                        [ x, y, x]
                    ];
                    console.log(coord);
                    const faces = [ // 面
                    [0,1,3,2],[5,4,6,7],
                    [0,4,5,1],[6,2,3,7],
                    [0,2,6,4],[3,1,5,7]
                    ];
                    
                    setInterval(draw);
                    
                    function draw(){ // 描画
                    const ctx = document.getElementById("canvas").getContext("2d");
                    ctx.clearRect(0, 0, camvas_width, camvas_height); // 初期化
                    
                    let sorted = faces.map((a,i)=>[a,i]).sort((a,b)=>rem(a[0])-rem(b[0])); // facesをsortしたもの
                    for(let i of sorted){ //画の描写
                        let rtteds = []; // 回転後の座標を記録する配列
                        for(let j of i[0]){
                        rtteds.push(rotat(...coord[j])) // 回転後の座標
                        }
                    
                        ctx.beginPath(); //描写スタート
                        ctx.fillStyle = ["pink","blue","orange","aqua","red","green"][i[1]];
                    
                        ctx.moveTo(100 + rtteds[0][0], camvas_width/2 - rtteds[0][2]);
                        for(let j of rtteds){
                        ctx.lineTo(100 + j[0], camvas_height/2 - j[2]);
                        }
                        ctx.fill();
                    }
                    }
                    
                    function rem(ary){ // 遠さを調べる関数
                    return ary.map(a=>rotat(...coord[a])[1]).reduce((a,b)=>a+b)/ary.length;
                    }
                    
                    let ang1 = 0;
                    let ang2 = 0;
                    
                    function rotat(x, y, z){ // 角度の分だけ回転
                    [x, y] = [x*Math.cos(ang1) - y*Math.sin(ang1), x*Math.sin(ang1) + y*Math.cos(ang1)];
                    [y, z] = [y*Math.cos(ang2) - z*Math.sin(ang2), y*Math.sin(ang2) + z*Math.cos(ang2)];
                    return [x,y,z];
                    }
                    
                    document.body.onkeydown = e =>{
                    switch(e.keyCode){
                        case 37:
                        ang1-=0.1; // 左
                        break;
                        case 38:
                        ang2-=0.1; // 上
                        break;
                        case 39:
                        ang1+=0.1; // 右
                        break;
                        case 40:
                        ang2+=0.1; // 下
                        break;
                    }
                    };
                        
                    });
                });
        </script>
</body>
</html>
