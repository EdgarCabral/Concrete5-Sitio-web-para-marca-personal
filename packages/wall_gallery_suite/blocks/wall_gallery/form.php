<?php     
defined('C5_EXECUTE') or die(_("Access Denied."));
$al = Loader::helper('concrete/asset_library');
?>
<style>
    #btn-launch-file-manager { margin-top: 23px; }
    .thumb-item-shell { border: 5px solid #fff; box-shadow: 0 0 5px #ccc; margin: 0 10px 10px; padding: 3px; display: inline-block; cursor: move; }
    .thumb-file-name { font-size: 9px; }
</style>
<?php  $addSelected = true; ?>
<p>
<?php   print Loader::helper('concrete/ui')->tabs(array(
    array('pane-thumbs', t('Images'), $addSelected),
    array('pane-settings', t('Options'))
));?>
</p>
<div class="ccm-tab-content" id="ccm-tab-content-pane-thumbs">
    <div class="form-group">
        <label><?php  echo t('Select Fileset')?></label>
        <select class="form-control" name="fileset" id="form-select-fileset">
            <option value="none"><?php  echo t('None')?></option>
            <?php    foreach ($sets as $set){ ?>
            <option value="<?php    echo $set->fsID; ?>" <?php   if($fileset==$set->fsID){echo "selected";}?>><?php  echo $set->fsName?></option>
            <?php   } ?>
        </select>
    </div>
    <!-- leaving this alone for now -->
    <!--<div class="col-xs-3">
        <a href="javascript:launchFileManager();" class="btn btn-primary" id="btn-launch-file-manager">Launch File Manager</a>
    </div>-->
    <p><?php  echo t('For a custom arrangement, simply drag and drop the image thumbnails.')?></p>
    <div class="well" id="items-container"></div>  
    <input type="hidden" id="toolURL" value="<?php  echo $toolsURL?>">  
</div>
<div class="ccm-tab-content" id="ccm-tab-content-pane-settings">
	<div class="row">
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("thumbnail", t("Thumbnails Button")); ?>
				<?php   echo $form->select("thumbnail", array("true"=>t("Enabled"), "false"=>t("Disabled")), $thumbnail?$thumbnail:"true"); ?>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("controls", t("Control Buttons")); ?>
				<?php   echo $form->select("controls", array("true"=>t("Enabled"), "false"=>t("Disabled")), $controls?$controls:"true"); ?>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("counter", t("Counter")); ?>
				<?php   echo $form->select("counter", array("true"=>t("Enabled"), "false"=>t("Disabled")), $counter?$counter:"true"); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("closable", t("Closable")); ?>
				<?php   echo $form->select("closable", array("true"=>t("Enabled"), "false"=>t("Disabled")), $closable?$closable:"true"); ?>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("escKey", t("Enable ESC Key?")); ?>
				<?php   echo $form->select("escKey", array("true"=>t("Yes"), "false"=>t("No")), $escKey?$escKey:"true"); ?>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("captionEnable", t("Enable Caption")); ?>
				<?php   echo $form->select("captionEnable", array("true"=>t("True"), "false"=>t("False")), $captionEnable?$captionEnable:"true"); ?>
			</div>
		</div>
	</div>
    <div class="row">
        <div class="col-xs-4">
            <div class="form-group">
                <?php   echo $form->label("pause", t("Pause Duration")); ?>
                <div class="input-group">
                    <?php   echo $form->text("pause",$pause?$pause:"4000"); ?>
                    <div class="input-group-addon"><?php  echo t('ms')?></div>
                </div>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
                <?php   echo $form->label("thumbMargin", t("Thumbnail Margins")); ?>
                <div class="input-group">
                    <?php   echo $form->text("thumbMargin",$thumbMargin?$thumbMargin:"5"); ?>
                    <div class="input-group-addon"><?php  echo t('px')?></div>
                </div>
            </div>
        </div>        
        <div class="col-xs-4">
            <div class="form-group">
                <?php   echo $form->label("easing", t("Ribbon Easing Effect")); ?>
                <?php   echo $form->select("easing",array(
					"easeOutExpo"=>t("Ease Out Expo"),
					"easeInOutExpo"=>t("Ease In-Out Expo"),
					"easeInExpo"=>t("Ease In Expo"), "linear"=>t("Linear"),
					"jswing"=>t("Swing"), "easeInQuad"=>t("Ease In Quad"),
					"easeOutQuad"=>t("Ease Out Quad"), "easeInOutQuad"=>t("Ease In Out Quad"),
					"easeInCubic"=>t("Ease In Cubic"), "easeOutCubic"=>t("Ease Out Cubic")),$easing?$easing:"easeOutExpo"); ?>
            </div>
        </div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div class="form-group">
				<?php   echo $form->label("hideControlOnEnd", t("Hide Upon End")); ?>
				<?php   echo $form->select("hideControlOnEnd", array("false"=>t("Disabled"), "true"=>t("Enabled")), $hideControlOnEnd?$hideControlOnEnd:"false"); ?>
			</div>
		</div>
        <div class="col-xs-4">
            <div class="form-group">
				<?php   echo $form->label("loopable", t("Loop Gallery")); ?>
				<?php   echo $form->select("loopable", array("false"=>t("Disabled"), "true"=>t("Enabled")), $loopable?$loopable:"false"); ?>
			</div>
        </div>
		<div class="col-xs-4">
            <div class="form-group">
				<?php   echo $form->label("auto", t("Slideshow Mode")); ?>
				<?php   echo $form->select("auto", array("false"=>t("Disabled"), "true"=>t("Enabled")), $auto?$auto:"false"); ?>
			</div>
        </div>
    </div>
</div>
<script>
     
<?php   if(!$bID){$bID=0;}?>     
function indexItems(){
    $(".thumb-item-shell").each(function(i){
        $(this).find(".item-sort").val(i);
    });
}
$("#items-container").sortable({
    update: function(){
        indexItems();
    }
});
function launchFileManager(){
    ConcreteFileManager.launchDialog();
};
function getThumbs(){
    var selectedFileSet = $("#form-select-fileset").val();
    var toolURL = $("#toolURL").val();
    //if they selected a fileset
    if(selectedFileSet != 'none'){
        $.ajax({
            type: "POST",
            data: {fsID: selectedFileSet, bID: <?php  echo $bID?>},
            dataType: 'json',
            url: toolURL,
            success: function(thumbs) {
                $("#items-container").html(thumbs);
                indexItems();
            },
            error: function(){
                $("#items-container").html("Something went wrong...");
            }
        });
    } else{
        //they selected none
        $("#items-container").html("Choose a Fileset");
    }
}
getThumbs();
$("#form-select-fileset").change(function(){
    getThumbs();
});    
</script>