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
        $hasAuth = $this->MyAuth->user('auth');
        $this->set(compact('id', 'hasAuth'));

        $user = $this->users->find('all')
                     ->where(['users.id =' => $id]);

        $rooms = $this->rooms->find('all');
        
        foreach ($rooms as $room) {
            //debug($room);
        }

        $this->set(compact('rooms'));
        

    }

    public function add() {
        $this->loadModel('users');
        $this->loadModel('rooms');
        $id =$this->MyAuth->user('id');
        $hasAuth = $this->MyAuth->user('auth');
        $this->set(compact('id', 'hasAuth'));

        $room = $this->Rooms->newEntity();

        if ($this->request->is('post')) {
            $room->name = $this->request->data('name'); 
            $room->deleted_flg = 0; 
var_dump($room);

            if ($this->Rooms->save($room)) {
                var_dump("test");

              $this->Flash->success(__('部屋を新規追加しました。'));
              return $this->redirect(['action' => 'index']);
            } else {
                dump("test2");
                exit;
            }
            $this->Flash->error(__('部屋の新規登録に失敗しました。'));
        }
        $this->set(compact('room'));
        
    }

    public function edit ($room_id) {
        $room = $this->Rooms->findById($room_id)->fiirst;
    }

    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
