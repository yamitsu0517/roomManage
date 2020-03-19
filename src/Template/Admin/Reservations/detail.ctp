<?php
$hours_st = '09:00'; //設定開始時間('hh:nn'で指定)
$hours_end = '21:30'; //設定終了時間('hh:nn'で指定)
$hours_margin = 30; //間隔を指定(分)

$tbl_flg = True; //時間を横軸 → true, 縦軸 → falseにする
$master_key = 'special';

//設定時間を計算して配列化
$hours_baff = new DateTime( $date .' ' . $hours_st ); //配列格納用の変数
$hours_end_date = new DateTime( $date . ' ' . $hours_end ); //終了時間を日付型へ

$hours = array('0' => ''); //時間を格納する配列
array_push($hours, $hours_baff->format('H:i')); //配列に追加
$hours_baff = $hours_baff->modify ("+{$hours_margin} minutes"); //設定間隔を足す
while ( $hours_baff <= $hours_end_date ) { //終了時間まで繰り返す
    if ( $hours_baff->format('H:i') == '00:00' ){ //終了時間が00:00だったら
        array_push($hours, '24:00'); //24:00で配列に追加
    } else {
        array_push($hours, $hours_baff->format('H:i')); //配列に追加
    }
    $hours_baff = $hours_baff->modify ("+{$hours_margin} minutes"); //設定間隔ずつ足していく
}

// パスワードありがクリックされた時表示させる。
if (isset($_POST['kwd_delete'])) {
    echo "<div id='confirm_kwd'>";
        echo "<form method='POST'>
            <p>秘密鍵を入力してください</p>
            <input type='text' name='delete_kwd'>
            <input type='hidden' name= 'kwd' value='". $_POST['kwd'] . "'>
            <input type='hidden' name='id' value='". $_POST['id'] ."'>
            <input type='submit' name='kwd_btn' value='削除する'>";
        echo "</form>";
    echo "</div>";

}
/*
*
* タイムテーブル生成のための下準備をする部分 
* 部屋ごとに値を入れる配列
*
*/

foreach ($rooms as $room) {
	for ( $i = 1; $i <= count($hours); $i++ ) {
		$data_meta[$room->name][$i] = null; //配列を定義しておく（エラー回避）
	}
}
$roomName = [];
$num = 1;
foreach ($rooms as $room) {
    $roomName[$num] = $room->name;
    $num++;
}

//タイムテーブル設定
if ( $tbl_flg == true ) {
	$clm = $hours; //縦軸 → 時間
	$row = $roomName; //横軸 → 設定項目
	$clm_n = count($clm) - 1; //縦の数（時間配列の-1）
	$row_n = count($row); //横の数
} else {
	$clm = $roomName; //縦軸 → 設定項目
	$row = $hours; //横軸 → 時間
	$clm_n = count($clm); //縦の数
	$row_n = count($row) - 1; //横の数（時間配列の-1）
}

$err_n = 0; //エラー件数カウント用
$data_n = 1; //0はデータ無しにしたいので、1から始める


if (isset($reservationData)){ 

    foreach ( $reservationData as $value) { //指定日付のデータ数繰り返す

        $key1 = null; //エラーキャッチ用にnullを入れておく
        $key2 = null;
        // 20/2/5 10:10:10.0000 を直す
        $time1 = date('Y-m-d H:i:d', strtotime($value->start_time));
        $time2 = date('Y-m-d H:i:d', strtotime($value->end_time));

        $time1 = substr($time1, 11, 5); //該当データの開始日時'00:00'抜出
        $key1 = array_search($time1, $hours); //時間配列内の番号	
        $time2 = substr($time2, 11, 5); //該当データの終了日時'00:00'抜出
        $key2 = array_search($time2, $hours); //時間配列内の番号

        //$data_meta['項目名']['開始時間配列番号']へナンバリングしていく
        $data_meta[$value['room']['name']][$key1] = $data_n;

        //必要な情報を格納しておく
        $ar_block[$data_n] = $key2 - $key1; //開始時間から終了時間までのブロック数
        $ar_userId[$data_n] = $value->user_id;
        $ar_id[$data_n] = $value->id;
        $ar_name[$data_n] = $value->user->name;
        $ar_purp[$data_n] = $value->purpose;
        $ar_kwd[$data_n] = $value->kwd;
        $ar_dlt[$data_n] = $value->deleted_flg;
        $data_n++; //データ数カウントアップ
    }    
}

// rowspan結合数を格納する配列にゼロを入れておく
for ( $i = 0; $i <= $clm_n; $i++ ) {
	$span_n[$i] = 0; 
}


// ここから、タイムテーブルを作成していく。
echo "<div class='main'>";
echo '<table id="timetable">'."\n<thead>\n<tr>\n".'<th id="origin">時間</th>'."\n";
for ( $i = 1; $i <= $clm_n; $i++ ) {
	echo '<th class="cts">&nbsp;'.$clm[$i]."</th>\n"; //横軸見出し
}

echo "</tr>\n</thead>\n<tbody>\n";
for ( $i = 1; $i <= $row_n; $i++ ) { //縦軸の数繰り返す
	echo "<tr><td>".$row[$i].'</td>'; //縦軸見出し
	for ( $j = 1; $j <= $clm_n; $j++ ) { //横軸の数繰り返す
		if ( $tbl_flg == false && $span_n[$j] >= 0 ) { //時間軸が縦の場合の繰り上げ処理
			$span_n[$j]--; //rowspan結合の数だけtd出力をスルー
		} else { //通常時
			$block = '';
			$data_n = 0; //ゼロはデータ無し
			if ( $tbl_flg == true ) { //時間軸が横なら
                $data_n = $data_meta[$row[$i]][$j];
                // echo "<pre>";
                // var_dump($data_meta[$row[$i]]);
                // echo "</pre>";

			} else { //時間軸が縦なら
				$data_n = $data_meta[$clm[$j]][$i];
			}
			if ( $data_n == 0 || $ar_dlt[$data_n] == 1) { //データが無いとき
				echo '<td>&nbsp;</td>'; //空白を入れる
            } else { //データが有るとき
				if ( $ar_block[$data_n] > 1 ) { //ブロックが2つ以上
					if ($tbl_flg == true) { //時間軸が横だったら
						$block = ' colspan="'.$ar_block[$data_n].'"'; //横方向へ結合
						$j = $j + $ar_block[$data_n] - 1; //colspan結合ぶん横軸数を繰り上げ
					} else { //時間軸が縦だったら
						$block = ' rowspan="'.$ar_block[$data_n].'"'; //縦方向へ結合
						$span_n[$j] = $ar_block[$data_n] - 1; //rowspan結合数を格納→冒頭で繰り上げ処理
					}
				}
                $cts = h($ar_name[$data_n]).'<br />'.h($ar_purp[$data_n]); //htmlエスケープしながら中身成形
                $dlt = '';

				if ( $ar_kwd[$data_n] == '' ) { //削除キー無
                    //onsubmitでJavaScriptを呼び出す
                    
                    if ($ar_userId[$data_n] == $id || $hasAuth >=1) {
                        $dlt = '<form action="" method="post" onsubmit="return dltChk()">
                        <input type="hidden" name="date" value="'.$date.'" />
                        <input type="hidden" name="user_id" value="'.$ar_userId[$data_n].'" >
                        <input type="hidden" name="id" value="'.$ar_id[$data_n].'" />
                        <input type="hidden" name="id" value="'.$hasAuth.'" />
                        <input type="submit" name="delete" value="×"></form>';
                    }
				} else { //削除キー有
                    //カギ画像付加

                    if ($ar_userId[$data_n] == $id) {
                        $dlt = '<form action="" method="post"><input type="hidden" name="date" value="'.$date.'" />
                        <input type="hidden" name="id" value="'.$ar_id[$data_n].'" />
                        <input type="hidden" name="user_id" value="'.$ar_userId[$data_n].'" >
                        <input type="hidden" name="kwd" value="'.$ar_kwd[$data_n].'">
                        <input type="submit" name="kwd_delete" value="×">
                        </form><img src="../../../img/key.png" width="18" height="18">' ;
                        // echo "a";
                        // $this->Html->image("key.png")
                    }    
                }

				echo '<td class="exist"'.$block.'>'.$cts.$dlt.'</td>'; //tdの中に出力
			}
		}
	} //横軸for
	echo "</tr>\n";
} //縦軸for
echo "</tbody>\n</table>\n";

?>



<!-- 予約フォーム（年月日から入れるもの -->

<?php


$templateStart = array(
        // 'type' => 'time',
        'label' => '',
        'dateFormat' => 'H:i',
        'monthNames' => false,
        // 'min' => '09:00',
        // 'max' => '21:00',
        'separator' => '-',
        'minYear' => date('Y'),
        'maxYear' => date('Y')+1,
        'default' => date('Y-m-d h:i'),
        'interval' => 30,
        'require' => true

);
$templateEnd = array(
    // 'type' => 'time',
    'label' => '',
    'dateFormat' => 'YMD',
    'monthNames' => false,
    'separator' => '-',
    'minYear' => date('Y'),
    'maxYear' => date('Y')+1,
    // 'minTime' => '09:00',
    // 'maxTime' => '21:00',
    'default' => date('Y-m-d h:i'),
    'interval' => 30,
    'require' => true
);

?>
<div class="form">
    <h2>予約フォーム</h2>
    <p>※秘密鍵は任意です</p>
    <div class="form">
        <?php
        // ラジオボタン用のデータ作成
        $options = [];
        $conut = 1;
        foreach ($rooms as $room) {;
            $option[$conut] = $room->name;
            $conut++;
        }

        echo "<table>";
        echo "<form method='post' id='reservation'>";
        // echo $this->Form->create('reservations',['method'=>'GET']);
        if (isset($dateData)){
            echo "<input type='hidden' name='dateData' value={$dateData}>";
        }
        echo "<tr>";
            echo "<th>使う部屋：</th>";
            echo "<td>";
                echo $this->Form->radio('room_id', $roomName, ['value' => '1']);
        echo "</td></tr>";
        echo "<tr><th>";
            echo "開始時間：";
        echo "</th><td>";
            // echo $this->Form->time('start_time',$templateStart);
            echo "<input type='time' id='start_time' name='start_time' max='21:30' min='09:00' step=1800 required>";

        echo "</td></tr>";
        echo "<tr><th>";
            echo "終了時間：";
        echo "</th><td>";
            // echo $this->Form->time('end_time',$templateEnd);
            echo "<input type='time' id='end_time' name='end_time' max='22:00' min='09:00' step=1800 required>";
        echo "</td></tr>";
        echo "<tr><th>目的：</th><td>";
            // echo $this->Form->input('purpose',['label' => '']);
            echo "<input type='text' id='purpose' name='purpose' required>";
        echo "</td></tr>";
        echo "<tr><th>";
            echo "秘密鍵：";
        echo "</th><td>";
            // echo $this->Form->input('key', ['label' => '']) . "</td></tr>";
            echo "<input type='text' id='kwd' name='kwd' required>";
        echo "<tr><td></td><td></td><td>";
        // echo $this->Form->button('予約する');
        echo "<input type='submit' id='btn' name='btn' value='予約する'>";
        echo "</td></tr>";
        // echo $this->Form->end();
        echo "</form>";

        echo "</table>";
        ?>
    </div>
</div>
</div>