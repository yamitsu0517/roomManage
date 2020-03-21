<?php
foreach ($users as $val) {
    $ids[$val->id] = $val->name;
}
?>

<table  >
<?php if (!$hasAuth) { ?>
    <?=$this->Form->create($user)?>
    <tr>
        <td class='user_edit'>
            <?=$this->Form->input('email',array(
                'label' => 'メールアドレス：',
                ));?>
        </td>
    </tr>
    <tr>
        <td class='user_edit'>
            <?=$this->Form->input('password', array(
                'label' => '　　パスワード：',
            ));?>
        </td>
    </tr>
    <tr>
        <td class='user_edit'>
            <?=$this->Form->input('name', array(
                'label' => '　　　　　名前：',
            ));?>
        </td>
    </tr>
    <tr>

        <td>
            <?=$this->Form->button("更新する", [
                'id' => 'userEdit'
            ]);?>
        </td>
    </tr>
    <?= $this->Form->end()?>
<?php } elseif ($hasAuth) { ?>
    <?=$this->Form->select('id', $ids, [
        'id' => 'userId'
    ]);?>
    <tr>
        <th>ユーザ番号</th>
        <th>ユーザ名</th>
        <th>編集</th>
    </tr>
<?php foreach ($users as $u) { ?>
    <tr>
        <td>
            <?= $u['id']?>
        </td>
        <td>
            <?= $u['name']?>
        </td>
        <td>
            <?php echo $this->Html->link('編集する', ['controller' => 'users', 'action' => 'edit', $u['id']]); ?>
        </td>

    </tr>
 <?php } ?>

<?php } ?>
</table>