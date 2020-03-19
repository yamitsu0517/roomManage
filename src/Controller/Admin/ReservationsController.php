<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\ORM\TableRegistry;

class ReservationsController extends AppController {
    
    public function initialize() {
        parent::initialize();
        // $this->rooms = TableRegistry::get('Rooms');
        // $this->reservations = TableRegistry::get('Reservations');
    }


    public function index() {
        $homeMenus = [];

        $homeMenus['部屋予約'] = ['controller' => 'Reservations' , 'action' => 'add'];

        $this->set(compact('homeMenus'));
    }


    /*
     * 主にdetail function がmain
     * @param YYYYmmdd 形式
     * 
     */
    public function detail($data=null) {
        
        $this->loadModel('rooms');
        $this->loadModel('reservations');
        $id =$this->MyAuth->user('id');
        $hasAuth = $this->MyAuth->user('auth');
        $name = $this->MyAuth->user('name');
        $rooms = $this->reservations->rooms->find('all');
        
        // GET送信された8桁を変換
        $date = date('Y-m-d', strtotime($data));
        $this->set(compact(('date')));
        $reservationData ="";
        // 該当日時の予約情報取得
        $reservationData = $this->reservations->find('all')
                    ->contain(['rooms', 'users'])
                    ->where(['reservations.start_time >=' => $date . " 00:00:00", 
                            'reservations.end_time <=' => $date . " 23:59:59"]);

        // 今日の日付を取得 
        $today = date('Y-m-d'); //YYYY-MM-DDの形

        $this->set(compact('id', 'hasAuth', 'name', 'reservationData', 'rooms', 'today'));
        
        $today = str_replace('-','',$today);

        // 今日より前にアクセスしたら、ホームに戻す
        if (strtotime($today) > strtotime($date)) {
            $this->Flash->error(__('選択した日にちは表示出来ません。'));
            return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
        }
        /*
         * insert 処理
         *
         */
        if (isset($_POST['btn'])) {
            $reservation = $this->Reservations->newEntity();
            if ($this->request->is('post')) {
                $this->insert($date, $id, $reservationData);
            }
        }

        $this->set(compact('reservation'));
        

        /*
         * delete 処理
         *
         */
        if (isset($_POST['delete'])) {
            $deletingData = $this->request->data;
            $deletedId = $deletingData['id'];
            $user_id = $deletingData['user_id'];
            
            $reservation = $this->Reservations->findById($deletedId)->first();

            if ($id == $user_id || $hasAuth) {
                $reservation->deleted_flg = 1;
                if ($this->Reservations->save($reservation)) {
                    $this->Flash->success('削除しました。');
                    return $this->redirect(["action" => "detail", $data]);
                } else {
                    $this->Flash->error(__('削除に失敗しました。'));
                }
            }
         }
        if (isset($_POST['kwd_btn'])) {
            $deletingData = $this->request->data;
            $deletedId = $deletingData['id'];
            $deletedPass = $deletingData['delete_kwd'];
            $deletedKwd  = $deletingData['kwd'];

            $reservation = $this->Reservations->findById($deletedId)->first();

            if ($deletedPass) {
                if ($deletedPass == $deletedKwd) {
                    $reservation->deleted_flg = 1;
                    if ($this->Reservations->save($reservation)) {
                        $this->Flash->success('削除しました。');
                        return $this->redirect(["action" => "detail", $data]);
                    } else {
                        $this->Flash->error(__('削除に失敗しました。'));
                    }
                } else {
                    $this->Flash->error(__('秘密鍵が違います。'));
                }
            }
        }

    }


    

    public function add() {
        $hasAuth = $this->MyAuth->user('auth');

        $this->set(compact('hasAuth'));
    }


    /*
     * @param  date 'YYYY-mm-dd' 形式
     * @param  id   ログインユーザのID
     * @param  reservationData 該当日時のデーダ
     * @return 挿入処理 or 失敗
     */
    private function insert($date, $id, $reservationData) {
        $reservation = $this->Reservations->newEntity();
            if ($this->request->is('post')) {
                
                $request = $this->request;
                $start_time = $date .' ' . $request->data('start_time') . ':00';
                $end_time   = $date .' ' . $request->data('end_time') . ':00'; 
                $room_id    = $request->data('room_id');
                $purpose    = $request->data('purpose');
                
                $add_data = array(
                    'start_time' => $start_time,
                    'end_time'   => $end_time,
                    'room_id'    => $room_id,
                    'purpose'    => $purpose
                );
                // validate check
                $validate = $this->validate($add_data, $reservationData);
                
                // 日付用の - 抜き文字作成
                $day = str_replace('-', '', $date);

                if ($validate['result'] == 'False') {
                    $this->Flash->error(__($validate['message']));
                } elseif ($validate['result'] == "True") {
                    $reservation->user_id = $id;
                    $reservation->room_id = $room_id;
                    $reservation->start_time = $start_time;
                    $reservation->end_time = $end_time;
                    $reservation->purpose = $request->data('purpose');
                    $reservation->kwd = $request->data('kwd');
                    $reservation->deleted_flg = $request->data('deleted_flg');
var_dump($reservation);
exit;
                    if ($this->Reservations->save($reservation)) {
                        // ユーザ作成と同じセッションに代入
                        // $this->MyAuth->setUser($reservation);
                        $this->Flash->success($validate['message']);
                        return $this->redirect(["action" => "detail", $day]);
                        // ログイン後のページに遷移
                        // return $this->redirect($this->MyAuth->redirectUrl());
                    } else {
                            $this->Flash->error(__('予約に失敗しました。'));
                    }
                } 
                
            }
    }

    // 開始時間と、終了時間がか被っていないかチェックする。
    private function validate($add_data, $reservationData=null) {
        // foreach の中に入ったかどうか確認
        $confirm_flg = False;

        // 開始時間が格納されているか確認
        if ($add_data['start_time'] == '') {
            return array(
                'result' => 'False',
                'message' =>'開始時間を入力してください。'
            );
        }
        // 終了時間が格納されているか確認
        if ($add_data['end_time'] == '') {
            return array(
                'result' => 'False',
                'message' => '終了時間を入力してください。'
            );
        }
        // 部屋が格納されているか確認
        if ($add_data['room_id'] == '' || $add_data['room_id'] == 0) {
            return array(
                'result' => 'False',
                'message' => '使用する部屋の値は適正な値を入力してください。'
            );
        }
        // 目的が格納されているか確認
        if ($add_data['purpose'] == '') {
            return array(
                'result' => 'False',
                'message' => '使用目的を記入してください。'
            );
        }

        foreach ($reservationData as $reservation) {
            $confirm_flg = True; 
            $time_st  = strtotime($reservation->start_time);
            $time_end = strtotime($reservation->end_time);

            // 時を格納
            $time_st_h  = date('H', strtotime($reservation->start_time));
            $time_end_h = date('H', strtotime($reservation->end_time));
            // 分を格納
            $time_st_m  = date('i', strtotime($reservation->start_time));
            $time_end_m = date('i', strtotime($reservation->end_time));

            // 時間判定
            if ($time_st_h <  9 || $time_st_h > 21) {
                return array(
                    'result' => 'False',
                    'message' => '開始時間は 9~21時30分の間にしてください。'
                );
            } elseif ($time_end_h <  9 || $time_end_h > 22) {
                return array(
                    'result' => 'False',
                    'message' => '終了時間は 9時30分~22時の間にしてください。'
                );

            } elseif ($time_st_m % 30 != 0 || $time_end_m %30 !=0) {
                return array(
                    'result' => 'False',
                    'message' => '分は30分単位にしてください。'
                );
            // 目的判定
            } elseif ($add_data['purpose'] == "" || $add_data['purpose'] ==null) {
                return array(
                    'result' => 'False',
                    'message' => '目的を記入してください。'
                );
            } 

            // 部屋と時間が被っていないか判定
            if ($add_data['room_id'] == $reservation->room_id) {
                // 開始時間 <= 予約されている開始時間 && 予約されている開始時間 < 終了時間
                if ( strtotime($add_data['start_time']) <= $time_st && $time_st < strtotime($add_data['end_time']) ) {
                    $flg = "False";
                }
                if ( strtotime($add_data['start_time']) < $time_end && $time_end <= strtotime($add_data['end_time']) ) {
                    $flg = "False"; 
                }
                if ( $time_st <= strtotime($add_data['start_time']) && strtotime($add_data['end_time']) <= $time_end ) {
                    $flg = "False"; 
                } 
                if ($reservation->deleted_flg == 1) {
                    return  array(
                        'result' => 'True',
                        'message' => '予約しました。'
                    );
                }
                return array(
                    'result' => $flg,
                    'message' => 'すでに予約されています。'
                );
            }

            // 引っ掛からなかったら、登録してみる。
            return array(
                'result' => 'True',
                'message' => '登録できちゃった。'
            );
        }
        // foreach の中に入らなかったら。（テーブルにデータがないとき）
        if ($confirm_flg === False) {
            return array(
                'result' => "True",
                'message' => '予約しました。'
            );
        }
    }

}
