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
            
	    function id_youtube_A($url) {
		    $patron = '%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x';
		    $array = preg_match($patron, $url, $parte);
		    if (false !== $array) {
		        return $parte[1];
		    }
		    return false;
	    }
		
            foreach ($pages as $page) { $posicion++;  ?>
		<?php
		if($class_page != "grilla"){ 
			if($posicion == 1){ 
				$item_size = "item--expanded-medium"; 
			}else if($posicion == 2){ 
				$item_size = "item--medium"; 
			}else{ 
				$item_size = "item--medium"; 
			}
		}else{ 
			$item_size = "item--medium"; 
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
                }else{
                    $youtube = $page->getAttribute('youtube');
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
		        $style = "background-image: url('".$src."');";
		        ?>
	                <?php
	        } ?>
	        <?php
	        	if(isset($youtube) && $youtube){
				$ID_youtube = id_youtube_A($youtube);
	        		$src = "https://img.youtube.com/vi/".$ID_youtube."/0.jpg";
	        		
		        	$style = "background-image: url('".$src."');";
		        }
		?>
	        <a href="<?php echo h($url) ?>" target="<?php echo h($target) ?>" class="item <?php if($item_size){ echo $item_size; }else{ echo $page->getAttribute('class_page'); } ?>">
                    
                    <div class="item__details_" style="<?php if(isset($style) && $style){ echo $style; } ?>">

                    
                    </div>
                    
                    <?php if ($includeEntryText) {
                        ?>
	                    <?php if (isset($includeName) && $includeName) { ?>
	                    		<style>
	                    			@media screen and (max-width: 768px) {
							.grid {
							  grid-gap: 20px;
							  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
							  grid-auto-rows: 150px;
							  grid-auto-flow: row dense;
							}
							.item--medium {
							  grid-row-end: span 2;
							}
						}
	                    		</style>
	                            <h3 style="text-aign:center; color: #001c54; font-family: 'Gotham Bold', Arial; text-transform: uppercase;"><?php echo h($title) ?></h3>
	                    <?php } ?>
	
	                    <?php if (isset($includeDate) && $includeDate) {
	                        ?>
	                        <div style="border-top:1px solid #CCC; width:150px; margin:5px auto;"></div>
	                        <span style="color: #777; margin-bottom: 20px;"><i><?php echo h($date) ?></i></span>
	                        <?php
	                    } ?>
	
	                    <?php if (isset($includeDescription) && $includeDescription) {
	                        ?>
	                        <p style="color: #ccc;"><?php echo h($description) ?></p>
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
