<?php
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController {

    public function initialize() {
        
        parent::initialize();

        // ユーザ登録とログインとためにMyAuthを使う
        $this->loadComponent("MyAuth");
        // 以下のアクションのみアクセス可能にする。
        $this->MyAuth->allow(['login','register']);
    }

    public function login() {
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            // IDとパスワードの妥当性の確認

            $user = $this->MyAuth->identify();
            if ($user) {
                // セッションに代入
                $this->MyAuth->setUser($user);
                // ログイン後のページに遷移
                return $this->redirect($this->MyAuth->redirectUrl());
            } else {
                $this->Flash->error(__('IDまたはパスワードが間違っています。'));
            }
        }
        $this->set(compact('user'));
    }

    public function register() {
        
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {

            $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($user)) {
                // ユーザ作成と同じセッションに代入
                $this->MyAuth->setUser($user);
                $this->Flash->success('ユーザ登録に成功しました。');
                // ログイン後のページに遷移
                return $this->redirect($this->MyAuth->redirectUrl());
            }
            $this->Flash->error(__('ユーザ登録に失敗しました。'));
            
        }
        $this->set(compact('user'));
    }
}