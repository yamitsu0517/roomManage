<div clss="navbar navbar-default nabar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <?= $this->Html->link('部屋管理', '/users/login') ?>
        </div>
    <div class="collapse navbar-nav">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <?= $this->Html->link('ログイン','/users/login')?>
            </li>
            <li class="dropdown">
                <?= $this->Html->link('ユーザ登録', '/users/register')?>
            </li>
        </ul>
    </div>
</div>