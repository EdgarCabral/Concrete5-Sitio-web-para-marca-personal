<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

$c = Page::getCurrentPage();
$u = new User();
if($c->isEditMode()) {
	echo '<style>';
	echo '	.c5h-call-to-action-wrap {';
	echo '		position: relative!important;';
	echo '		top: auto!important;';
	echo '		left: auto!important;';
	echo '		z-index: 5!important;';
	echo '	}';
	echo '</style>';
} else if($u->isLoggedIn()) {
	echo '<style>';
	echo '	.c5h-call-to-action-wrap {';
	echo '		position: fixed;';
	echo '		top: 49px;';
	echo '		left: 0;';
	echo '		z-index: 5;';
	echo '	}';
	echo '	body {';
	echo '		margin-top: 99px!important;';
	echo '	}';
	echo '</style>';
} else {
	echo '<script>';
	echo '	$(document).ready(function(){';
	echo '		$("body").css("margin-top", "50px");';
	echo '	});';
	echo '</script>';
}
?>

<div class="c5h-call-to-action-wrap"<?php  echo $backgroundColor;?>>
	<div class="c5h-call-to-action-branding">
		<a href="http://c5hub.com/store" title="concrete5 Themes & Add-ons" target="_blank">
			<img src="<?php  echo $this->getBlockURL()?>/images/c5hub-logo.png" alt="c5hub-logo">
		</a>
	</div><!-- END .c5h-call-to-action-branding -->
	<div class="c5h-call-to-action-content">
		<div class="c5h-call-to-action-left"><?php  echo $text;?></div>	
		<div class="c5h-call-to-action-right"><?php  echo $button;?></div>
	</div><!-- END .c5h-call-to-action-content -->
	<div class="c5h-call-to-action-close">
		<span class="fa fa-close"></span>
	</div><!-- END .c5h-call-to-action-close -->
</div><!-- END .c5h-call-to-action-wrap -->