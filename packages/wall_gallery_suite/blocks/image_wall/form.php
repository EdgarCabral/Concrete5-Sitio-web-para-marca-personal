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
	<div class="form-group">
        <?php   echo $form->label("captionEnable", t("Enable Caption")); ?>
        <?php   echo $form->select("captionEnable", array("true"=>t("True"), "false"=>t("False")), $captionEnable?$captionEnable:"true"); ?>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <?php   echo $form->label("ribbonAnim", t("Ribbon Animation Speed")); ?>
                <div class="input-group">
                    <?php   echo $form->text("ribbonAnim",$ribbonAnim?$ribbonAnim:"500"); ?>
                    <div class="input-group-addon"><?php  echo t('ms')?></div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <?php   echo $form->label("imageAnim", t("Image Animation Speed")); ?>
                <div class="input-group">
                    <?php   echo $form->text("imageAnim",$imageAnim?$imageAnim:"400"); ?>
                    <div class="input-group-addon"><?php  echo t('ms')?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">        
        <div class="col-xs-6">
            <div class="form-group">
                <?php   echo $form->label("easing", t("Ribbon Easing Effect")); ?>
                <?php   echo $form->select("easing",array(
					"easeOutExpo"=>t("Ease Out Expo"),
					"easeInOutExpo"=>t("Ease In-Out Expo"),
					"easeInExpo"=>t("Ease In Expo"), "linear"=>t("Linear"),
					"jswing"=>t("Swing"), "easeInQuad"=>t("Ease In Quad"),
					"easeOutQuad"=>t("Ease Out Quad"), "easeInOutQuad"=>t("Ease In Out Quad"),
					"easeInCubic"=>t("Ease In Cubic"), "easeOutCubic"=>t("Ease Out Cubic")
					),$easing?$easing:"easeOutExpo"); ?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <?php  echo $form->label("imgeasing", t("Image Easing Effect")); ?>
				<?php   echo $form->select("imgeasing",array(
					"easeOutExpo"=>t("Ease Out Expo"),
					"easeInOutExpo"=>t("Ease In-Out Expo"),
					"easeInExpo"=>t("Ease In Expo"), "linear"=>t("Linear"),
					"jswing"=>t("Swing"), "easeInQuad"=>t("Ease In Quad"),
					"easeOutQuad"=>t("Ease Out Quad"), "easeInOutQuad"=>t("Ease In Out Quad"),
					"easeInCubic"=>t("Ease In Cubic"), "easeOutCubic"=>t("Ease Out Cubic")
					),$imgeasing?$imgeasing:"easeOutExpo"); ?>
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