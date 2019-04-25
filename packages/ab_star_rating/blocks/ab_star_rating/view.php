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

$bUID = $controller->getBlockUID($b);
$form_action = $view->action('rate', $app->make('token')->generate('rate_form_'.$bUID));

?>

<div class="ab-rating">
    <div id="rating_spinner_img_<?php echo $bUID; ?>" class="spinner-img hidden"><img src="<?php echo $img_url; ?>spinner.gif" /></div>
    <div id="rating_errors_<?php echo $bUID; ?>" class="alert alert-danger hidden" role="alert"></div>
    <div id="rating_success_<?php echo $bUID; ?>" class="alert alert-success hidden" role="alert"><?php echo t('Thank you for your rating'); ?></div>
    
    <form id="rate_form_<?php echo $bUID; ?>" action="<?php echo $form_action?>" method="post" accept-charset="utf-8">
        <div id="ab_rating_<?php echo $bUID; ?>" class="ab-rating-stars" data-buid="<?php echo $bUID; ?>" data-rating="<?php echo h($js_data); ?>"></div>
    </form>
    <?php if ($show_av_rating) { ?>
        <p class="average-rating"><?php echo t('Average rating') . ': ' . $average_rating; ?></p>
    <?php } ?>
</div>
