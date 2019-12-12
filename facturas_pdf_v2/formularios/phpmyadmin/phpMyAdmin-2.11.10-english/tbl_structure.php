
    </tr>
        <?php
    }
    if (!$is_innodb && isset($showtable['Data_length']) && $showtable['Rows'] > 0 && $mergetable == false) {
        ?>
    <tr class="<?php echo ($odd_row = !$odd_row) ? 'odd' : 'even'; ?>">
        <th class="name"><?php echo $strRowSize; ?> &oslash;</th>
        <td class="value"><?php echo $avg_size . ' ' . $avg_unit; ?></td>
    </tr>
        <?php
    }
    if (isset($showtable['Auto_increment'])) {
        ?>
    <tr class="<?php echo ($odd_row = !$odd_row) ? 'odd' : 'even'; ?>">
        <th class="name"><?php echo $strNext; ?> Autoindex</th>
        <td class="value"><?php echo PMA_formatNumber($showtable['Auto_increment'], 0); ?></td>
    </tr>
        <?php
    }
    if (isset($showtable['Create_time'])) {
        ?>
    <tr class="<?php echo ($odd_row = !$odd_row) ? 'odd' : 'even'; ?>">
        <th class="name"><?php echo $strStatCreateTime; ?></th>
        <td class="value"><?php echo PMA_localisedDate(strtotime($showtable['Create_time'])); ?></td>
    </tr>
        <?php
    }
    if (isset($showtable['Update_time'])) {
        ?>
    <tr class="<?php echo ($odd_row = !$odd_row) ? 'odd' : 'even'; ?>">
        <th class="name"><?php echo $strStatUpdateTime; ?></th>
        <td class="value"><?php echo PMA_localisedDate(strtotime($showtable['Update_time'])); ?></td>
    </tr>
        <?php
    }
    if (isset($showtable['Check_time'])) {
        ?>
    <tr class="<?php echo ($odd_row = !$odd_row) ? 'odd' : 'even'; ?>">
        <th class="name"><?php echo $strStatCheckTime; ?></th>
        <td class="value"><?php echo PMA_localisedDate(strtotime($showtable['Check_time'])); ?></td>
    </tr>
        <?php
    }
    ?>
    </tbody>
    </table>
    <?php
}
// END - Calc Table Space

require './libraries/tbl_triggers.lib.php';

echo '<div class="clearfloat"></div>' . "\n";
echo '</div>' . "\n";

/**
 * Displays the footer
 */
require_once './libraries/footer.inc.php';
?>
