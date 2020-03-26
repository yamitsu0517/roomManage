<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class RoomsController extends AppController {

    public function initialize() {
        parent::initialize();
    }
    
    public function index() {
        $this->loadModel('users');
        $this->loadModel('rooms');
        $id =$this->MyAuth->user('id');
        $user = $this->users->findById($id)->first();
        $hasAuth = $user['auth'];
        $this->set(compact('id', 'hasAuth'));

        $user = $this->users->find('all')
                     ->where(['users.id =' => $id]);

        $rooms = $this->rooms->find('all');
        
        $this->set(compact('rooms'));
    }

    public function add() {
        $this->loadModel('users');
        $this->loadModel('rooms');
        $id =$this->MyAuth->user('id');
        $hasAuth = $this->MyAuth->user('auth');
        $this->set(compact('id', 'hasAuth'));

        $rooms = $this->rooms->find('all');
        $room = $this->Rooms->newEntity();

        if ($this->request->is('post')) {
            $room->name = $this->request->data('name'); 
            $room->deleted_flg = 0; 
            
            // 同じ名前がないか確認
            $textFlg = false;
            $confirmFlg = true;
            foreach ($rooms as $r) {
                if ($r->name != $room->name && $r->deleted_flg == 1) {
                    $textFlg = true;
                    $confirmFlg = false;
                }
            }
            if ($confirmFlg) {
                // table の中にない->データがない
                $textFlg = true;
            }
            if (! $textFlg) return $this->Flash->error(__('部屋名が重複しています。'));
            if ($this->Rooms->save($room)) {

              $this->Flash->success(__('部屋を新規追加しました。'));
              return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('部屋の新規登録に失敗しました。'));
        }
        $this->set(compact('room'));
        
    }

    public function edit ($room_id) {
        $this->loadModel('rooms');
        $hasAuth = $this->MyAuth->user('auth');
        $room = $this->Rooms->findById($room_id)->first();
        $rooms = $this->Rooms->find('all');

        $this->set(compact('hasAuth', 'room'));

        if ($this->request->is('put')) {

            $room = $this->Rooms->patchEntity($room, $this->request->data);

            $validate = $this->validate($room, $rooms);
            if ($validate['result']) {
                if ($this->Rooms->save($room)) {
                    $this->Flash->success(__('部屋名を更新しました'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('部屋名の更新に失敗しました'));
            } else {
                $this->Flash->error(__($validate['message']));
            }
		} else if ($room === null){
			$this->Flash->error(__('対象の部屋が存在しません'));
			return $this->redirect(['action' => 'index']);
		}
    }


    public function delete($roomId) {
        $this->loadModel('Rooms');
        $room = $this->Rooms->findById($roomId)->first();

        $room->deleted_flg = 1;
        if ($this->Rooms->save($room)) {
            $this->Flash->success('削除しました。');
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__("削除に失敗しました。"));
        }
    }

    /**
     * @param $room 変更したい内容
     * @param $rooms テーブルデータ
     * @return array
     */
    public function validate($room, $rooms) {

        foreach ($rooms as $r) {
            if ($room['name'] == $r['name'] && $room['id'] != $r['id']) {
                return [
                    'result'  => false,
                    'message' => '部屋名が重複しています。'
                ];
            }
        }
        return [
            'result' =>true
        ];
    }

    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
