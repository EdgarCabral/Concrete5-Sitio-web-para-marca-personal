<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
?>
<div class="paddingBlock">
<div class="equalHMRWrap eqWrapr row">

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

        <div class="equalHMR eq col-lg-4 col-sm-6 col-xs-12">

        <?php if (is_object($thumbnail)): ?>
        <a href="<?php echo $url ?>" target="<?php echo $target ?>" style="text-decoration: none;">
            <div class="card">
                
	        <?php
                /*Core::make('html/image', array($thumbnail));
                $tag = $img->getTag();
                $tag->addClass('activator img-responsive materialboxed br-5');
                print $tag;*/
                
                $src = $thumbnail->getThumbnailURL('small');
                $style = "background-image: url('".$src."');";
                ?>
                
                <div class="foto_portada_item" style="<?php echo $style; ?>"></div>
                <div class="card-body">

                    <h3>
                	<?php echo $title; ?>
                    </h3>

	            <?php if ($includeDate): ?>
	                <div class="ccm-block-page-list-date"><?=$date?></div>
	            <?php endif; ?>
	
	            <?php if ($includeDescription): ?>
                        <p>
                            <?php echo $description ?>
                        </p>
	            <?php endif; ?>
	            
	            <?php if (isset($useButtonForLink) && $useButtonForLink) { ?>
                        <small><?php echo h($buttonLinkText) ?></small>
                    <?php } ?>
		</div>
            </div>
        </a>
        <?php endif; ?>

        </div>

	<?php endforeach; ?>

    <?php if (count($pages) == 0): ?>
        <div class="ccm-block-page-list-no-pages"><?=h($noResultsMessage)?></div>
    <?php endif;?>

</div>
</div>

<?php if ($showPagination): ?>
    <?php echo $pagination;?>
<?php endif; ?>

<?php if ($c->isEditMode() && $controller->isBlockEmpty()): ?>
    <div class="ccm-edit-mode-disabled-item"><?=t('Empty Page List Block.')?></div>
<?php endif; ?>