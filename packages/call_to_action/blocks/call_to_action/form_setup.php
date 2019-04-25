<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
//Restrict this to one instance per page
$page = Page::getCurrentPage();
$pageBlocks = $page->getBlocks();
$blockInUse = 0;
foreach ($pageBlocks as $pageBlock){
	if ($pageBlock->btHandle == 'call_to_action') {
		$blockInUse = 1;
	}
}

if(!$blockInUse || $controller->getTask() == 'edit'){

$al = Loader::helper('concrete/asset_library');
$form = Loader::helper('form');
$fh = Loader::helper('form/color');
?>

<script>
$(function() {
    $('div.ccm-block-feature-select-icon').on('change', 'select', function() {
        var $preview = $('i[data-preview=icon]');
            icon = $(this).val();

        $preview.removeClass();
        if (icon) {
            $preview.addClass('fa fa-' + icon);
        }
    });
});
</script>

<style>
div.ccm-block-feature-select-icon {
    position: relative;
}
div.ccm-block-feature-select-icon i {
    position: absolute;
    right: 40px;
    top: 38px;
}
.ccm-ui .well {
	margin-bottom: 0;
}
</style>

<div class="alert alert-info" role="alert">
	<i class="fa fa-exclamation-triangle fa-3x pull-left"></i> <?php  echo t('Want to remove the c5Hub logo? Need more control over the layout? <br/>Check out our PRO version here - ').'<a href="http://bit.ly/19l6pyV" target="_blank">'.t('Call to Action PRO').'</a>'?>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php  echo t('Content');?></h3>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<?php  echo $form->label('callToActionText', t('Text'))?>
			<?php  echo $form->text('callToActionText', $callToActionText)?>
		</div>
		<div class="form-group ccm-block-feature-select-icon">
			<?php  echo $form->label('callToActionFonticon', t('Icon'))?>
			<?php  echo $form->select('callToActionFonticon', $icons, $callToActionFonticon);?>
			<i data-preview="icon" <?php  if($callToActionFonticon) { ?>class="fa fa-<?php  echo $callToActionFonticon?>"<?php  } ?>></i>
		</div>		
		<div class="form-group">
			<?php  echo $form->label('callToActionLinkText', t('Button Text'))?>
			<?php  echo $form->text('callToActionLinkText', $callToActionLinkText)?>
		</div>
		<div></div><!-- Needed for Button Link Type Selector to work... -->
		<div class="well well-sm">
			<div class="form-group">
				<?php  echo $form->label('linkType', t('Button Link'))?>
				<select name="linkType" id="linkType" class="form-control">
					<option value="0" <?php  echo (empty($externalLink) && empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php  echo t('None')?></option>
					<option value="1" <?php  echo (empty($externalLink) && !empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php  echo t('Another Page')?></option>
					<option value="2" <?php  echo (!empty($externalLink) ? 'selected="selected"' : '')?>><?php  echo t('External URL')?></option>
				</select>
			</div>
			<div id="linkTypePage" style="display: none;" class="form-group">
				<?php  echo $form->label('internalLinkCID', t('Choose Page:'))?>
				<?php  echo Loader::helper('form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
			</div>			
			<div id="linkTypeExternal" style="display: none;" class="form-group">
				<?php  echo $form->label('externalLink', t('URL'))?>
				<?php  echo $form->text('externalLink', $externalLink); ?>
			</div>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-tint"></i> <?php  echo t('Color');?></h3>
	</div>
	<div class="panel-body">	
		<div class="row">
			<div class="col-md-3">
				<div class="well well-sm">
					<div class="form-group">
						<small><?php  echo $form->label('callToActionBackgroundColor', t('Background'))?></small><br/>
						<?php  echo $fh->output('callToActionBackgroundColor', $callToActionBackgroundColor);?>
					</div>
				</div>
			</div>		
			<div class="col-md-3">
				<div class="well well-sm">
					<div class="form-group">
						<small><?php  echo $form->label('callToActionTextColor', t('Text'))?></small><br/>
						<?php  echo $fh->output('callToActionTextColor', $callToActionTextColor);?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="well well-sm">
					<div class="form-group">
						<small><?php  echo $form->label('callToActionLinkTextColor', t('Button Text'))?></small><br/>
						<?php  echo $fh->output('callToActionLinkTextColor', $callToActionLinkTextColor);?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="well well-sm">
					<div class="form-group">
						<small><?php  echo $form->label('callToActionButtonColor', t('Button Background'))?></small><br/>
						<?php  echo $fh->output('callToActionButtonColor', $callToActionButtonColor);?>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>

<?php 

} else {
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('a.pull-right.btn.btn-primary').hide();
		});
	</script>
	<div class="alert alert-danger" role="alert">
		<?php  echo t('Sorry. The nature of this block means its use is limited to one instance per page.');?>
	</div>		
<?php  }?>