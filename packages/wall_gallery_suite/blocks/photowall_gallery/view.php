<?php  
defined('C5_EXECUTE') or die(_("Access Denied.")); 
$c = Page::getCurrentPage();
if (is_object($c) && $c->isEditMode()) { 
	//disable in edit mode
	echo '<style >.wgs_edit_disable{width:100%;min-height:20px;background:#999999;padding:10px;text-align:center;color:#fff}
	.wgs_edit_disable.error{color:#cf0000} a:focus{outline:none!important;} </style>';?>
	<div class="wgs_edit_disable"><h4><?php  echo t('Photowall Gallery disabled in edit mode.')?></h4></div>
<?php  } else { 
	if(!count($items)>0){ ?>
		<div class='well'>
		<?php  echo t("You have not choosen a fileset, or there's no files in the set you have choosen.");?>
		</div>
<?php  } else { ?>
<!-- Begin Photowall -->
<div class="photowall-wrap">
	<div id="photowall-<?php  echo $bID ?>">
        <?php  $ih = Loader::helper("image");
		$page = Page::getCurrentPage();
		foreach($items as $item){            
			$fileObj = File::getByID($item['fID']);  
			if(is_object($fileObj)){
        ?>
		<a href="<?php  echo $fileObj->getURL();?>" title="<?php  echo $fileObj->getTitle();?>"><img src="<?php  echo $fileObj->getURL();?>" alt="<?php  echo $fileObj->getTitle();?>" /></a>
	<?php  }//if is_obj
    }//for each?>
	</div>
	<script type="text/javascript">
		$('#photowall-<?php  echo $bID ?>').justifiedGallery({
			rowHeight : <?php  echo $rowHeight ?>, maxRowHeight: '<?php  echo $maxRowHeight ?>%', lastRow: '<?php  echo $lastRow ?>', fixedHeight: <?php  echo $fixedHeight ?>,
			captions: <?php  echo $captionEnable ?>, margins : <?php  echo $margins ?>, randomize: <?php  echo $randomize ?>
		}).on('jg.complete', function () {
			$('#photowall-<?php  echo $bID ?> a').swipebox( { hideBarsDelay: <?php  echo $hideBarsDelay ?>, loopAtEnd: <?php  echo $loopatEnd ?> });
		});
	</script>
</div>
<!-- End Photowall -->
<?php  } } ?>