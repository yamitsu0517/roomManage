<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController {

    
    public function index() {
        $id =$this->MyAuth->user('id');
        $this->loadModel('users');

        $user = $this->users->find('all')
                     ->where(['users.id =' => $id]);

        $usr = [];
        foreach ($user as $val) {
            $usr['auth'] = $val->auth;
            $usr['name'] = $val->name; 
        }
        $hasAuth = $this->MyAuth->user('auth');
        $homeMenus = [];

        $homeMenus['部屋予約'] = ['controller' => 'Reservations' , 'action' => 'add'];

        // 日付取得
        $date = date('Y-m-d'); //YYYY-MM-DDの形
        $getYear = date('Y');
        $getDate = date('n');

        // $calendarOutput = $this->get_rsv_calendar($getYear, $getDate, $date);
        $calendarOutput ="2";
        $this->set(compact('homeMenus', 'calendarOutput', 'auth', 'usr', 'hasAuth'));

        if ($this->request->is('post')) {
            $dateData = $this->request->data;
            var_dump($dateData);
            // return $this->redirect(['controller' => 'Reservations', 'action' => 'detail']);
        }   

    }

    /*** カレンダー ***/
    // function get_rsv_calendar($yyyy, $mm, $date) {
    //     $thisyear = $yyyy; //年
    //     $thismonth = $mm; //月
    //     $unixmonth = mktime(0, 0 , 0, $thismonth, 1, $thisyear); //該当月1日のタイムスタンプ
    //     $last_day = date('t', $unixmonth); //該当月の日数
    
    //     $calendarOutput = '<table class="rsv_calendar" border="2">
    //     <caption>' . $thisyear .'年' . $thismonth . '月' . '</caption>
    //     <thead>
    //     <tr>';
    
    //     $myweek = array("日", "月", "火", "水", "木", "金", "土"); //曜日定義
    
    //     foreach ( $myweek as $wd ) {
    //         $calendarOutput .= "\n\t\t<th scope=\"col\" title=\"$wd\">$wd</th>"; //曜日出力
    //     }
    
    //     $calendarOutput .= "
    //                         </tr>
    //                         </thead>

    //                         <tbody>
    //                         <form method='post'>
    //                         <tr>";
    
    //     $pad = date('w', $unixmonth); //該当月1日の曜日番号（日:0～土:6）
    //     if ( 0 != $pad )
    //         $calendarOutput .= "\n\t\t".'<td colspan="'. $pad .'" class="pad">&nbsp;</td>'."\n\t\t";
    //     $newrow = false;
    //     for ( $day = 1; $day <= $last_day; ++$day ) { //1日から最終日まで繰り返し
    //         if ( isset($newrow) && $newrow ) {
    //             $calendarOutput .= "\n\t</tr>\n\t<tr>\n\t\t"; //行フラグ$newrowがtrueなら
    //         }
    //         $newrow = false; //行フラグリセット
    
    //         $sp_date = explode("-", $date); //引数$dateを分割
    //         if ( $day == $sp_date[2] && $thismonth == $sp_date[1] && $thisyear == $sp_date[0] ) {
    //             $calendarOutput .= '<td id="current" class="calendar-text">'; //引数と一致する日にid付加
    //         } else if ( $day == date('j') && $thismonth == date('m') && $thisyear == date('Y') ) {
    //             $calendarOutput .= '<td id="today" class="calendar-text">'; //本日と一致する日にid付加
    //         } else {
    //             $calendarOutput .= '<td class="calendar-text">';
    //         }
    //         $calendarOutput .= '<input type="submit" name="calendar['.$thisyear.'-'.str_pad($thismonth,2,"0",STR_PAD_LEFT).'-'.str_pad($day,2,"0",STR_PAD_LEFT).']" value="'.$day.'">';
    //         $calendarOutput .= "</td>\n\t\t";
    
    //         if ( 6 == date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear)) )
    //             $newrow = true; //最終列なら行フラグを立てる
    //     }
    
    //     $pad = 7 - date('w', mktime(0, 0 , 0, $thismonth, $day, $thisyear));
    //     if ( $pad != 0 && $pad != 7 )
    //         $calendarOutput .= "\n\t\t".'<td class="pad" colspan="'. $pad .'">&nbsp;</td>'; //余ったtdを埋める
    
    //     $calendarOutput .= "\n\t</tr>\n\t</form>\n\t</tbody>\n</table>\n";
    
    //     return $calendarOutput;
    // }

    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}