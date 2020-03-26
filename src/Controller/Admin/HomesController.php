<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class HomesController extends AppController {

    
    public function index() {
        $id =$this->MyAuth->user('id');
        $this->loadModel('users');
        $user = $this->users->findById($id)->first();

        // 最初に登録した人に権限を付与する
        if ($id == 1 && $user['auth'] == null) {
            $user['auth'] = 1;
            if ($this->users->save($user)) {
                return $this->redirect(['action' => 'index']);
            }
        }

        $hasAuth = $user['auth'];
        $homeMenus = [];

        $homeMenus['部屋予約'] = ['controller' => 'Reservations' , 'action' => 'add'];

        // 日付取得
        $date = date('Y-m-d'); //YYYY-MM-DDの形
        $getYear = date('Y');
        $getDate = date('n');

        $this->set(compact('homeMenus', 'auth', 'usr', 'hasAuth'));
    }

    function h($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}