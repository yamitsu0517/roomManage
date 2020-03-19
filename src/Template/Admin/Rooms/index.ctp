<div>
    <p>部屋一覧</p>
</div>

<table>
    <tr>
        <th>部屋番号</th>
        <th>部屋名</th>
        <th>編集</th>
    </tr>
    <?php foreach ($rooms as $room): ?>
    <tr>
        <td>
            <?php echo $room->id?> 
        </td>
        <td>
            <?php echo $room->name?>
        </td>
        <td>
            <?php echo $this->Html->link('編集', ['action' => 'edit', $room->id]);?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
echo $this->Html->link('部屋登録', ['action' => 'add'] );