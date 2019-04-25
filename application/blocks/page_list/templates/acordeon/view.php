<?php
defined('C5_EXECUTE') or die("Access Denied.");
$th = Loader::helper('text');
$c = Page::getCurrentPage();
$cont=0;
?>


<?php if ($c->isEditMode()){ ?>
    <div class="ccm-edit-mode-disabled-item"><?=t('Lista en modo de ediciòn')?></div>
<?php }else if ($c->isEditMode() || $controller->isBlockEmpty()){ ?>
    <div class="ccm-edit-mode-disabled-item"><?=t('Empty Page List Block.')?></div>
<?php }else{ ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		$('.collapse').collapse();
	</script>
	
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

	    <?php if (isset($pageListTitle) && $pageListTitle): ?>
	        <div class="ccm-block-page-list-header">
	            <h5><?=h($pageListTitle)?></h5>
	        </div>
	    <?php endif; ?>
	    
	    <?php foreach ($pages as $page):
		
		$cont=$cont+1;
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
	
	        <div class="panel panel-default">
	
	        <?php if (is_object($thumbnail)){ ?>
	        
	                
		        <?php
		        /*Core::make('html/image', array($thumbnail));
		        $tag = $img->getTag();
		        $tag->addClass('activator img-responsive materialboxed br-5');
		        print $tag;*/
		        
		        $src = $thumbnail->getThumbnailURL('small');
		        $style = "background-image: url('".$src."');";
		        ?>
	        	
	      	    	
	            <div class="panel-heading" role="tab" id="heading<?php echo $cont; ?>">
		      <h4 class="panel-title">
			<?php if ($includeDescription){ ?>
			    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $cont; ?>" aria-expanded="true" aria-controls="collapse<?php echo $cont; ?>">
				<?php echo $title; ?>
		            </a>
	            	<?php }else{ ?>
	            	    <a href="<?php echo $url ?>" target="<?php echo $target ?>" style="text-decoration: none;">
	        		<?php echo $title; ?>
	        	    </a>
	        	<?php } ?>
		      </h4>
		    </div>
	
	            <?php if ($includeDescription){ ?>
	                <div id="collapse<?php echo $cont; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $cont; ?>">
	      		    <div class="panel-body">
		                    <div class="foto_portada_item" style="<?php echo $style; ?>"></div>
		
		                    <?php if ($includeDate): ?>
			                <b class="ccm-block-page-list-date"><?=$date?></b><br>
			            <?php endif; ?>
			            
		                    <?php echo $description ?>
		                    
		                    <?php if (isset($useButtonForLink) && $useButtonForLink) { ?><br>
		                    	<a class="btn btn-info" href="<?php echo $url ?>" target="<?php echo $target ?>" style="text-decoration: none; margin-top:10px;">
		                        	<?php echo h($buttonLinkText) ?>
		                        </a>
		                    <?php } ?>
		                    <div style="clear:both"></div>
		            </div>
	                </div>
	            <?php } ?>        
	        <?php } ?>
	
	        </div>
	
	    <?php endforeach; ?>
		
	
	    <?php if (count($pages) == 0): ?>
	        <div class="ccm-block-page-list-no-pages"><?=h($noResultsMessage)?></div>
	    <?php endif;?>
	
	</div>
	
	<?php if ($showPagination): ?>
	    <?php echo $pagination;?>
	<?php endif; ?>
<?php } ?>