<?php defined('C5_EXECUTE') or die("Access Denied."); 

/**
 * Star Rating package for Concrete5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Alex Borisov <linuxoidoz@gmail.com>
 * @copyright 2017-2018, Alex Borisov
 * @package Concrete\Package\ab_star_rating
 */

$config_database = $app->make('config/database');

?>

<form method="post" action="<?php echo $view->action('save'); ?>">

    <div class="form-group">
        <?php
        echo $form->label('min_wait', t('Min Wait Period between Posts (sec)'));
        echo $form->number('min_wait', $config_database->get('ab_star_rating.min_wait'), ['min' => '0', 'max' => '86400', 'class' => "decimals"]);
        echo '<p class="text-muted">' . t('Values from 0 to 86400 (86400 sec = 24 h)') . '</p>';
        ?>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button class="pull-right btn btn-success" id="action" type="submit" ><?php echo t('Save Settings'); ?></button>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('.decimals').keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                    ConcreteAlert.error({
                        title: <?php echo json_encode(t('Oops')); ?>,
                        message: <?php echo json_encode(t('Numbers only!')); ?>
                    });
                }
            });
        });
    </script>

</form>

<style>
.text-muted {
    font-size: 0.8em;
}
</style>

