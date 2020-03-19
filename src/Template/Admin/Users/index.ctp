
<div>
    <p>ユーザ情報を更新する</p>
</div>

<?php
foreach ($users as $val) {
    $ids[$val->id] = $val->name;
}
// debug($ids);

echo "<table>";
if (!$hasAuth) {
    echo $this->Form->create($user);
    echo "<tr>";
        echo "<td class='user_edit'>メールアドレス</td><td>：</td><td>" . $this->Form->input('email',array(
        'label' => '',
        ));
        echo "</td>";
    echo "</tr><tr>"; 
        echo "<td class='user_edit'>パスワード</td><td>：</td><td>" . $this->Form->input('password', array(
            'label' => '',
        ));
        echo "</td>";
    echo "</tr><tr>";
        echo "<td class='user_edit'>名前</td><td>：</td><td>" . $this->Form->input('name', array(
            'label' => '',
        ));
        echo "</td>";
    echo "</tr><td>";
    echo "<tr>";
        echo "<td></td><td></td><td>" .$this->Form->button("登録") . "</td>";
    echo "</tr>";
    echo $this->Form->end();
} elseif ($hasAuth) {
    echo "<p>ユーザ選択</p>";
    echo $this->Form->select('id', $ids);

}

echo "</table>";