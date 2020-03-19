<h1 class="page-header">ユーザ登録</h1>
<div class="form">
<?php
echo $this->Form->create($user);
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->input('name');
echo $this->Form->button('登録');
echo $this->Form->end();
?>
</div>