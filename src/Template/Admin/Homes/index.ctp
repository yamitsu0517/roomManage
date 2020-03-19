<?php
$today = date('Ymd'); //YYYYMMDDの形
$date  = date('Y-m-d');
$thisyear = (int)date('Y');
$thismonth = (int)date('m') -1;
//$thismonth = 5;
$thisday = (int)date('d');
$week = array("日", "月", "火", "水", "木", "金", "土"); //曜日定義
$unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear); //該当月1日のタイムスタンプ


$pad = date('w', $unixmonth); //該当月1日の曜日番号（日:0～土:6）


$last_day = date('t', $unixmonth); //該当月の日数

?>

<div class='row'>
    <div class='col-md-5'>
        <div class='list-group'>
            <?php
            foreach($homeMenus as $text => $link) {
                // echo $this->Html->link($text, $link, ['class' => 'list-group-item']);
            }
            ?>
        </div>
        <div class="calendarBox">
            <?php $i =0;
            while ($i <3): ?>
                <table class="calendar_body">
                    <?php 
                        $thismonth++;
                        $unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear); //該当月1日のタイムスタンプ
                        $pad = date('w', $unixmonth); //該当月1日の曜日番号（日:0～土:6）
                        $last_day = date('t', $unixmonth); //該当月の日数
                    ?> 
                    <caption><?php echo "{$thisyear}年{$thismonth}月"?></caption>
                    <thead>
                        <tr>
                            <?php foreach ( $week as $wd ):
                                echo "\n\t\t<th scope='col' title='$wd'>{$wd}</th>" ; //曜日出力
                            endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php if ( 0 != $pad ):
                                    echo "\n\t\t".'<td colspan="'. $pad .'" class="pad">&nbsp;</td>'."\n\t\t";
                                endif;
                                $newrow = false;
                                for ( $day = 1; $day <= $last_day; $day++ ) { //1日から最終日まで繰り返し
                                    
                                    echo   $this->Form->create(null, ['url' => [
                                        'controller' => 'reservations',
                                        'action' => 'detail',
                                        'type'   => 'GET',

                                    ]]);
                                    if ( isset($newrow) && $newrow ) {
                                        echo "\n\t</tr>\n\t<tr>\n\t\t"; //行フラグ$newrowがtrueなら
                                    }
                                    $newrow = false; //行フラグリセット

                                    // 日付を2桁で表示する
                                    $days = str_pad($day,2,"0",STR_PAD_LEFT);


                                    $sp_date = explode("-", $date); //引数$dateを分割
                                    if ( $day == $sp_date[2] && $thismonth == $sp_date[1] && $thisyear == $sp_date[0] ) {
                                        echo '<td id="current">'; //引数と一致する日にid付加
                                    } else if ( $day == date('j') && $thismonth == date('m') && $thisyear == date('Y') ) {
                                        echo '<td id="today">'; //本日と一致する日にid付加
                                    } else {
                                        echo '<td>';
                                    }
                                    $thismonth_s = "0" . (string)$thismonth;
                                    $unionDay = $thisyear . $thismonth_s . $days;
                                    $strUnionDay = strtotime($unionDay);
                                    // 今日
                                    $strDate = strtotime($date);

                                    if ($strDate > $strUnionDay) {    
                                        echo $day;
                                    } else {
                                        echo $this->Html->link($day, ['controller' => 'reservations', 'action' => 'detail', $unionDay]);
                                    }
                                    // echo "<input type='hidden' name='test' value='{$unionDay}'>";
                                    echo "</td>\n\t\t";
                                    
                                    if ( 6 == date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)) ) {
                                        $newrow = true; //最終列なら行フラグを立てる
                                    }
                                }
                                $pad = 7 - date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear));
                                if ( $pad != 0 && $pad != 7 ) {
                                    echo "\n\t\t".'<td class="pad" colspan="'. $pad .'">&nbsp;</td>'; //余ったtdを埋める
                                }
                                echo "\n\t</tr>\n\t</form>\n\t";  
                                ?>
                            </tr>
                    </tbody>
                </table>
            <?php 
            $i++ ;
            if ($thisyear == 12) $thisyear =1;
            endwhile; ?>
        </div>
    </div>
</div>
