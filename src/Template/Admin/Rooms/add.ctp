<table>
<?php
echo $this->Form->create('rooms');
echo "<tr>";
    echo "<td>部屋名：</td>";
    echo "<td>" . $this->Form->input('name', array(
        'label' => '',
    )) . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2'>";
    echo $this->Form->button('登録する');
echo "</td>";
echo $this->Form->end();
?>

</table>