<div>
    <p>部屋一覧</p>
</div>

<table>
    <tr>
        <th>部屋番号</th>
        <th>部屋名</th>
        <?php if ($hasAuth) {?>
        <th colspan='2'>編集</th>
        <?php } ?>
    </tr>
    <?php $cnt = 1 ?>
    <?php foreach ($rooms as $room): ?>
        <?php if ($room->deleted_flg) continue;?>
    <tr>
        <td>
            <?php echo $cnt++?> 
        </td>
        <td>
            <?php echo $room->name?>
        </td>
        <?php if ($hasAuth) { ?>
        <td>
            <?php echo $this->Html->link('編集', ['action' => 'edit', $room->id]);?>
        </td>
        <td>
        <?php echo $this->Html->link('削除', ['action' => 'delete', $room->id]);?>
        </td>
        <?php } ?>
    </tr>
    <?php endforeach; ?>
    <?php if ($hasAuth) { ?>
    <tr>
        <td colspan='3'>
        <?=$this->Html->link('部屋登録', ['action' => 'add'] );?>
        </td>
    </tr>
    <?php } ?>
</table>

