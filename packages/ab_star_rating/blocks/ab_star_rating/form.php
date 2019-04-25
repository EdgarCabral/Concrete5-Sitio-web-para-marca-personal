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

?>

<style>
.text-muted {
    font-size: 0.8em;
}

.ab-rating-form i {
    margin-top: 10px;
}
</style>

<fieldset class="ab-rating-form">

    <div class="form-group">
        <div id="block_note" class="alert alert-info" role="alert">
            <?php echo t('Rating block'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                echo $form->label('size', t('Star-Font Size (em)'));
                echo $form->number('size', $size ? $size : 1, ['min' => '0.7', 'max' => '2', 'step' => '0.1', 'class' => "decimals"]);
                echo '<p class="text-muted">' . t('Values from 0.7 to 2') . '</p>';
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?php
                echo $form->label('color', t('Star Color'));
                echo '<br />';
                $ch = $app->make('helper/form/color');
                $ch->output('color', $color ? $color : '#0099ff', array('showAlpha' => 'false', 'preferredFormat' => 'hex'));
                ?>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="checkbox">
            <label>
                <?php
                echo $form->checkbox('show_av_rating', 1, $show_av_rating);
                echo t('Show average rating?');
                ?>
            </label>
        </div>
    </div>
        
    <div class="form-group">
        <div class="checkbox" data-checkbox-wrapper="show_star_text">
            <label>
                <?php
                echo $form->checkbox('show_star_text', 1, $show_star_text);
                echo t('Show text with stars?');
                ?>
            </label>
        </div>
        <div data-fields="show_star_text" style="display: none">
            <div class="well">
                <div id="block_note" class="alert alert-info" role="alert">
                    <?php echo t('Max 256 characters'); ?>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $form->text('star1_text', $star1_text ? $star1_text : t('Awful'), ['maxlength' => 256]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $form->text('star2_text', $star2_text ? $star2_text : t('Bad'), ['maxlength' => 256]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $form->text('star3_text', $star3_text ? $star3_text : t('Ok'), ['maxlength' => 256]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $form->text('star4_text', $star4_text ? $star4_text : t('Good'), ['maxlength' => 256]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                    </div>
                    <div class="col-sm-10">
                        <?php echo $form->text('star5_text', $star5_text ? $star5_text : t('Awesome'), ['maxlength' => 256]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</fieldset>

<script type="text/javascript">
$(function(){
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
    
    $('#ccm-form-submit-button').on('click', function(e){
        var size = parseFloat($.trim($('#size').val()));
        if (size < 0.7 || size > 2.0) {
            e.preventDefault();  // stop form from submitting
            e.stopPropagation(); // stop anything else from listening to our event and screwing things up
            ConcreteAlert.error({
                title: <?php echo json_encode(t('Size value error:')); ?>,
                message: <?php echo json_encode(t('Size must be decimal value from 0.7 to 2')); ?>
            });
        }
        
    });
    
    $('#show_star_text').on('change', function() {
        $('div[data-fields=show_star_text]').toggle($(this).is(':checked'));
    }).trigger('change');
});
</script>
