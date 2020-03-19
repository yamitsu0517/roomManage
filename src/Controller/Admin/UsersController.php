<?php
namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class UsersController extends AppController {

    public function index() {
        $this->loadModel('users');
        $id      = $this->MyAuth->user('id');
        $hasAuth = $this->MyAuth->user('auth');

        //
        $user = $this->Users->get($id);
        // debug($user);
        $this->set(compact('hasAuth', 'user'));

        $this->set('edit.js', '/user_edit.js');

        $users = $this->Users->find('all');


        if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			if ($this->Users->save($user)) {
				$this->MyAuth->setUser($user->toArray());
				$this->Flash->success(__('ユーザ情報を更新しました'));
                // return $this->redirect(['action' => 'index']);
                return $this->redirect($this->MyAuth->redirectUrl());
			}
			$this->Flash->error(__('ユーザ情報の更新に失敗しました'));
		}
		unset($user["password"]);
		$this->set(compact('user', 'users'));
    }

    public function logout() {
        $this->Flash->success('ログアウトしました。');

        return $this->redirect($this->MyAuth->logout());
    }



    // Ajax 用のアクション
    public function replaceIndexArea() {
        $this->loadModel('users');
        // Ajax からのリクエストか、否かを確認
        if($this->request->is("ajax")){
            // select_number の有無を確認
            if(!$this->request->getData(["select_number"])){
                return false;
            }
 
            // 各値を取得
            $selectNumber = $this->request->getData(["select_number"]);
            $templateType = $this->request->getData(["template_type"]);
 
            // Topics テーブルから値を取得
            $users = $this->Users->find('all');
            $topicsList = $this->Topics->find()->where(["id"=>$selectNumber])->toArray();
 
            // 各値をテンプレートに渡す
            $this->set(compact("topicsList","selectNumber","templateType"));
        }
    }
}