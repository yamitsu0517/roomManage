<h1 class="page-header">部屋編集</h1>
<?php 
echo $this->Form->create($room);
echo $this->Form->input('name', [
    'label' => '部屋名：',
    'autocomplete' => 'off',
]);
echo $this->Form->hidden('deleted_flg', [
    'value' => '0'
]);
echo $this->Form->button("更新");
echo $this->Form->end();
?>