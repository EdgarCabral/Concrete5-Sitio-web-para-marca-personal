<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
?>

<script>
   $(document).on('ready', function() {
      $(".page-list-stick-a").removeClass("hidden");
      $(".page-list-plantilla-slick-a-loading").addClass("hidden");
      $(".page-list-stick-a").slick({
        vertical: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        adaptiveHeight: true,
        arrows: true,
        dots: true,        
	autoplay: true,   
      });
  });
</script>

<div class="page-list-plantilla-slick-a-loading" style="height:400px; text-align: center; vertical-align:center; padding-top:50px;">...</div>
<div class="page-list-stick-a slider lazy page-list-plantilla-slick-a hidden">

    <?php if (isset($pageListTitle) && $pageListTitle): ?>
        <div class="ccm-block-page-list-header">
            <h5><?=h($pageListTitle)?></h5>
        </div>
    <?php endif; ?>

    <?php foreach ($pages as $page):

        $title = $th->entities($page->getCollectionName());
        $url = $nh->getLinkToCollection($page);
        $target = ($page->getCollectionPointerExternalLink() != '' && $page->openCollectionPointerExternalLinkInNewWindow()) ? '_blank' : $page->getAttribute('nav_target');
        $target = empty($target) ? '_self' : $target;
        $thumbnail = $page->getAttribute('thumbnail');
        $hoverLinkText = $title;
        $description = $page->getCollectionDescription();
        $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
        $description = $th->entities($description);
        if ($useButtonForLink) {
            $hoverLinkText = $buttonLinkText;
        }

        ?>

        
        <div class="post-content-position">

        <?php if (is_object($thumbnail)): ?>
            <div class="ccm-block-page-list-page-entry-grid-thumbnail">
                <div class="container">
	            <div class="post-content-left wp-medium-6 wpcolumns <?php if ($title || $description) { }else{ echo 'hidden'; }?>">
	                <div class="recentpost-inner-content">
	                    <?php if ($title) {
	                    ?>
	                    	<h2 class="wp-post-title">
	                    		<?php if ($url) { ?>
			                    <a href="<?php echo $url ?>" target="<?php echo $target ?>">
			                <?php } ?>
	                    			<?php echo $title; ?>
	                    		<?php if ($url) { ?>
			                    </a>
			                <?php } ?>
	                    	</h2>
	                    <?php } ?>
	                    <div class="wp-post-content">
	                    	<?php if ($includeDate): ?>
		                    <div class="ccm-block-page-list-date"><?=$date?></div>
		                <?php endif; ?>
		                <?php if ($includeDescription): ?>
		                    <div class="wp-sub-content">
		                        <?php echo $description ?>
		                    </div>
		                <?php endif; ?>
	                    	<?php if ($useButtonForLink) { ?>
		                    <a href="<?php echo $url ?>" target="<?php echo $target ?>" class="readmorebtn">más información</a>
		                <?php } ?>
	                    </div>
	                </div>
	            </div>
	        </div>
                <div class="post-image-bg">
	                <?php if ($url) { ?>
	                    <a href="<?php echo $url ?>" target="<?php echo $target ?>">
	                <?php } ?>
	                <?php
		                $img = Core::make('html/image', array($thumbnail));
		                $tag = $img->getTag();
		                $tag->addClass('img-responsive');
		                echo $tag;
	                ?>
	                <?php if ($url) { ?>
	                    </a>
	                <?php } ?>
	         </div>

            </div>
        <?php endif; ?>

        </div>

	<?php endforeach; ?>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?=h($noResultsMessage)?></div>
    <?php endif;?>

</div>

<?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?=t('Empty Page List Block.')?></div>
<?php endif; ?>
