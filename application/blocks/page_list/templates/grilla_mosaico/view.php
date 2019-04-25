<?php
defined('C5_EXECUTE') or die("Access Denied.");

$c = Page::getCurrentPage();

/** @var \Concrete\Core\Utility\Service\Text $th */
$th = Core::make('helper/text');
/** @var \Concrete\Core\Localization\Service\Date $dh */
$dh = Core::make('helper/date');

if ($c->isEditMode() && $controller->isBlockEmpty()) {
    ?>
    <div class="ccm-edit-mode-disabled-item"><?php echo t('Empty Page List Block.') ?></div>
    <?php
} else {
	
    ?>

    <div class="ccm-block-page-grid-mosaico">
    
    	<div class="mensaje_grid">
	  Lo sentimos, tu navegador no soporta "CSS Grid". 😅
	</div>

        <?php if (isset($pageListTitle) && $pageListTitle) {
            ?>
            <div class="ccm-block-page-list-header">
                <h5><?php echo h($pageListTitle) ?></h5>
            </div>
            <?php
        } ?>

        <?php if (isset($rssUrl) && $rssUrl) {
            ?>
            <a href="<?php echo $rssUrl ?>" target="_blank" class="ccm-block-page-list-rss-feed">
                <i class="fa fa-rss"></i>
            </a>
            <?php
        } ?>

        <section class="section_grid">
            <div class="grid">

            <?php $posicion=0; $class_page=$c->getAttribute('class_page');
            
            $includeEntryText = false;
            if (
                (isset($includeName) && $includeName)
                ||
                (isset($includeDescription) && $includeDescription)
                ||
                (isset($useButtonForLink) && $useButtonForLink)
            ) {
                $includeEntryText = true;
            }
		
            foreach ($pages as $page) { $posicion++;  ?>
		
		<?php
		$item_size = "";
		if($class_page == "grid-aleatorio" || $class_page == 0){ 
			if($posicion== 1){ $item_size = "item--large";  }
			if($posicion== 2){ $item_size = "item--medium";  }
			if($posicion== 3){ $item_size = "item--noraml";  }
			if($posicion== 4){ $item_size = "item--medium";  }
        }
        if($class_page == "grid-big"){ 
			if($posicion== 1){ $item_size = "item--large";  }
			if($posicion== 2){ $item_size = "item--medium";  }
			if($posicion== 3){ $item_size = "item--medium";  }
			if($posicion== 4){ $item_size = "item--medium";  }
		}
		
                // Prepare data for each page being listed...
                $buttonClasses = 'ccm-block-page-list-read-more';
                $entryClasses = 'ccm-block-page-list-page-entry';
                $title = $page->getCollectionName();
                if ($page->getCollectionPointerExternalLink() != '') {
                    $url = $page->getCollectionPointerExternalLink();
                    if ($page->openCollectionPointerExternalLinkInNewWindow()) {
                        $target = '_blank';
                    }
                } else {
                    $url = $page->getCollectionLink();
                    $target = $page->getAttribute('nav_target');
                }
                $target = empty($target) ? '_self' : $target;
                $description = $page->getCollectionDescription();
                $description = $controller->truncateSummaries ? $th->wordSafeShortText($description, $controller->truncateChars) : $description;
                $thumbnail = false;
                if ($displayThumbnail) {
                    $thumbnail = $page->getAttribute('thumbnail');
                }
                if (is_object($thumbnail) && $includeEntryText) {
                    $entryClasses = 'ccm-block-page-list-page-entry-horizontal';
                }

                $date = $dh->formatDateTime($page->getCollectionDatePublic(), true);

                //Other useful page data...

                //$last_edited_by = $page->getVersionObject()->getVersionAuthorUserName();

                /* DISPLAY PAGE OWNER NAME
                 * $page_owner = UserInfo::getByID($page->getCollectionUserID());
                 * if (is_object($page_owner)) {
                 *     echo $page_owner->getUserDisplayName();
                 * }
                 */

                /* CUSTOM ATTRIBUTE EXAMPLES:
                 * $example_value = $page->getAttribute('example_attribute_handle', 'display');
                 *
                 * When you need the raw attribute value or object:
                 * $example_value = $page->getAttribute('example_attribute_handle');
                 */

                /* End data preparation. */

                /* The HTML from here through "endforeach" is repeated for every item in the list... */ ?>
                
                <?php if (is_object($thumbnail)) {
	                ?>
	                <?php
		        /*Core::make('html/image', array($thumbnail));
		        $tag = $img->getTag();
		        $tag->addClass('activator img-responsive materialboxed br-5');
		        print $tag;*/
		        
		        $src = $thumbnail->getThumbnailURL('medium');
		        $style = "background: url('".$src."');";
		        ?>
	                <?php
	        } ?>
	        <a href="<?php echo h($url) ?>" target="<?php echo h($target) ?>" class="item <?php if($class_page == 'grid-aleatorio' || $class_page == "grid-big" || $class_page == 0){ echo $item_size; }else{ echo $page->getAttribute('class_page'); } ?>" style="<?php echo $style; ?>">
		<div >
                    
                    <div class="item__details">

                    <?php if ($includeEntryText) {
                        ?>
	                    <?php if (isset($includeName) && $includeName) { ?>
	                            <h2 style="font-family:20px !important; margin:0px !important; text-aign:center; color: #FFF; text-shadow: 0 2px 3px rgba(0,0,0,0.7);"><?php echo h($title) ?></h2>
	                    <?php } ?>
	
	                    <?php if (isset($includeDate) && $includeDate) {
	                        ?>
	                        <div class="ccm-block-page-list-date"><?php echo h($date) ?></div>
	                        <?php
	                    } ?>
	
	                    <?php if (isset($includeDescription) && $includeDescription) {
	                        ?>
	                        <div class="ccm-block-page-list-description"><?php echo h($description) ?></div>
	                        <?php
	                    } ?>
	
	                    <?php if (isset($useButtonForLink) && $useButtonForLink) {
	                        ?>
	                        <div class="ccm-block-page-list-page-entry-read-more">
	                            <a href="<?php echo h($url) ?>" target="<?php echo h($target) ?>"
	                               class="<?php echo h($buttonClasses) ?>"><?php echo h($buttonLinkText) ?></a>
	                        </div>
	                        <?php
	                    } ?>
                        <?php
                    } ?>
                    </div>
                    
		</div>
		</a>
                <?php
            } ?>
            </div>
        </section ><!-- end .ccm-block-page-list-pages -->

        <?php if (count($pages) == 0) { ?>
            <div class="ccm-block-page-list-no-pages"><?php echo h($noResultsMessage) ?></div>
        <?php } ?>

    </div><!-- end .ccm-block-page-list-wrapper -->


    <?php if ($showPagination) { ?>
        <?php echo $pagination; ?>
    <?php } ?>

    <?php

} ?>
