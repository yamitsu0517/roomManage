<?php
namespace App\Controller\Admin;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('MyAuth');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);

        // 認証している場合はメニューをadmin用にする。
        $user = $this->MyAuth->user();
        $menu = 'default';

        if ($user) {
            $this->set('auth', $user);
            $menu = 'admin';
        }
        $this->set(compact('menu'));
    }

    // 認証メソッド(正規のユーザであればTrueを返し、そうでないならfalse)
    public function isAuthorized($user = null) {
        if ($user !== null) {
            return true;
        }
        return false;
    }

    /**
    * UA取得
    * @return string
    */
    function getUserAgent() {

        $userAgent = isset($_SERVER['HTTP_USER_AGENT'])? $_SERVER['HTTP_USER_AGENT'] : '';

        return $userAgent;
    }
    /**
    * SP判定
    * @return boolean true:SP false:PC
    */
    function isSp() {

        $ua = $this->getuserAgent();

        if (stripos($ua, 'iphone') !== false || // iphone
            stripos($ua, 'ipod') !== false || // ipod
            (stripos($ua, 'android') !== false && stripos($ua, 'mobile') !== false) || // android
            (stripos($ua, 'windows') !== false && stripos($ua, 'mobile') !== false) || // windows phone
            (stripos($ua, 'firefox') !== false && stripos($ua, 'mobile') !== false) || // firefox phone
            (stripos($ua, 'bb10') !== false && stripos($ua, 'mobile') !== false) || // blackberry 10
            (stripos($ua, 'blackberry') !== false) // blackberry
        ) {
            return true;
        } else {
            return false;
        }
    }
}