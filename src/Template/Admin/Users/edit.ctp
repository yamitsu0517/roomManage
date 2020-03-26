<table>
    <tr>
        <th>ユーザID</th>
        <th>ユーザ名</th>
        <th>メールアドレス</th>
        <th>権限</th>
    </tr>
    <?=$this->Form->create($user)?>
<?php if ($myId == $user['id']) { ?>
    <tr>
        <td>
<?php     echo $user['id'];?>
        </td>
        <td class='user_edit'>
<?php     echo $this->Form->input('name', ['label' => '']);?>
        </td>
        <td class='user_edit'>
<?php     echo $this->Form->input('email', ['label' => '']);?>
        </td>
        <td class='user_edit'>
            <?php echo $this->Form->input('auth', ['label' => '']);?>
        </td>
<?php } else { ?>
        <td class='user_edit'>
<?php     echo $user['id'];?>
        </td>
        <td class='user_edit'>
<?php     echo $user['name'];?>
        </td>
        <td class='user_edit'>
<?php     echo $user['email'];?>
        </td>
        <td class='user_edit'>
<?php     echo $this->Form->input('auth', ['label' => '']);?>
        </td>
<?php } ?>
        <td>
            <?=$this->Form->button("更新",['id' => 'userEdit']);?>
        </td>
    </tr>
    <?=$this->Form->end();?>
</table>