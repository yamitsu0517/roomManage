<!-- ログイン後のメニュー画面 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="header-top" role="navigation">
    <div class="header">
        <h2><?= $this->Html->link('部屋管理',['controller' => 'Homes', 'action' => 'index'],['class' => 'navbar-brand']); ?></h2>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar nav">
            <li class="dropdown">
                 <!-- ここに、入れたいリンクを入れてください  -->
            </li>
        </ul>
        <ul class="dropdown">
            <p class="navbar-text">ようこそ、<?=$auth['name']; ?> さん</p>
            <?php if ($hasAuth) {?><p>(管理者)</p><?php } ?>
            <li class="dropdown-head">
                <div>
                <?=$this->Html->link('ユーザ管理', '#', ['data-toggle' => 'dropdown','class' => 'dropdown-toggle'   ])?>
                </div>
                <ul class="dropdown-menu">
                    <li><?=$this->Html->link('ユーザ編集', '/admin/users/index')?></li>
                    <li><?=$this->Html->link('ログアウト', '/admin/users/logout')?></li>
                </ul>
            </li>
            <li class="">
                <?=$this->Html->link('おまけ', '#',['data-toggle' => 'dropdown'])?>
                <ul class="dropdown-menu">
                    <li><?=$this->Html->link('図形作成', '/admin/reservations/add')?></li>
                </ul>
            </li>
            <?php if ($auth):?>
                <li class="">
                    <?=$this->Html->link('部屋管理', '#',['data-toggle' => 'dropdown'])?>
                    <ul class="dropdown-menu">
                        <li><?=$this->Html->link('部屋一覧', '/admin/rooms/index')?></li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
