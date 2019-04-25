<?php  
defined('C5_EXECUTE') or die(_("Access Denied.")); 
$c = Page::getCurrentPage();
if (is_object($c) && $c->isEditMode()) { 
	//disable in edit mode
	echo '<style >.wgs_edit_disable{width:100%;min-height:20px;background:#999999;padding:10px;text-align:center;color:#fff}
	.wgs_edit_disable.error{color:#cf0000} a:focus{outline:none!important;} </style>';?>
	<div class="wgs_edit_disable"><h4><?php  echo t('Wall Gallery is disabled in edit mode.')?></h4></div>
<?php  } else { 
	if(!count($items)>0){ ?>
	<div class="well">
		<?php  echo t("You have not choosen a fileset, or there's no files in the set you have choosen.");?>
	</div>
<?php  } else { ?>
<!-- Begin Wall Gallery -->
<div class="wallgallery-wrap">
	<script>
    $(document).ready(function() {
		$("#wallgallery-<?php  echo $bID ?>").lightGallery({
			mode: 'slide', easing: '<?php  echo $easing ?>', html:<?php  echo $captionEnable ?>,
			thumbnail:<?php  echo $thumbnail ?>, thumbMargin: <?php  echo $thumbMargin ?>, controls:<?php  echo $controls ?>, hideControlOnEnd: <?php  echo $hideControlOnEnd ?>, 
			loop: <?php  echo $loopable ?>, auto: <?php  echo $auto ?>, pause: <?php  echo $pause ?>, escKey:<?php  echo $escKey ?>, closable:<?php  echo $closable ?>, counter:<?php  echo $counter ?>
		});
	});
	</script>
	<ul id="wallgallery-<?php  echo $bID ?>" class="wallgallery">
        <?php  $ih = Loader::helper("image");
		$page = Page::getCurrentPage();
		foreach($items as $item){            
			$fileObj = File::getByID($item['fID']);  
			if(is_object($fileObj)){ ?>
			<li data-src="<?php  echo $fileObj->getURL(); ?>" class="nailthumb-container" <?php  if($captionEnable) { ?>data-html="<h3><?php  echo $fileObj->getTitle();?></h3><p><?php  echo $fileObj->getDescription();?></p>"<?php  } ?>>
				<a href="#"><img src="<?php  echo $fileObj->getURL(); ?>" alt="<?php  echo $fileObj->getTitle(); ?>" <?php  if($captionEnable) { ?>title="<?php  echo $fileObj->getTitle();?>"<?php  } ?> /></a>
			</li>
	<?php  }//if is_obj
    }//for each?>
	</ul>
</div>
<!-- End Wall Gallery -->
<?php  } } ?>