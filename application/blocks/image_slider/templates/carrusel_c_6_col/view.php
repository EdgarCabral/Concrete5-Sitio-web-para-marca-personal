<?php defined('C5_EXECUTE') or die("Access Denied.");
$navigationTypeText = (0 == $navigationType) ? 'arrows' : 'pages';
$c = Page::getCurrentPage();
if ($c->isEditMode()) {
    $loc = Localization::getInstance();
    $loc->pushActiveContext(Localization::CONTEXT_UI); ?>
    <div class="ccm-edit-mode-disabled-item" style="<?php echo isset($width) ? "width: $width;" : ''; ?><?php echo isset($height) ? "height: $height;" : ''; ?>">
        <i style="font-size:40px; margin-bottom:20px; display:block;" class="fa fa-picture-o" aria-hidden="true"></i>
        <div style="padding: 40px 0px 40px 0px"><?php echo t('Image Slider disabled in edit mode.'); ?>
			<div style="margin-top: 15px; font-size:9px;">
				<i class="fa fa-circle" aria-hidden="true"></i>
				<?php if (count($rows) > 0) {
        ?>
					<?php foreach (array_slice($rows, 1) as $row) {
            ?>
						<i class="fa fa-circle-thin" aria-hidden="true"></i>
						<?php
        }
    } ?>
			</div>
        </div>
    </div>
    <?php
    $loc->popActiveContext();
} else {
    ?>
<script>
   $(document).on('ready', function() {
      $(".vertical-center-c").removeClass("hidden");
      $(".plantilla-slick-c-loading").addClass("hidden");
      $(".vertical-center-c").slick({
        vertical: false,
        infinite: true,
        centerMode: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        adaptiveHeight: true,
            <?php if (0 == $navigationType) { ?>
		arrows:true,
		dots: false,
		<?php
	    } elseif (1 == $navigationType) {
	        ?> 
		dots: true,
		arrows:false,
		<?php
	    } elseif (2 == $navigationType) {
	        ?>
	        arrows: true,
	        dots: true,
	        <?php
	    } else {
	        ?>
		arrows:false,
		dots: false,
		<?php
	    } ?>
	    <?php if ($timeout) {
	        echo "autoplaySpeed: $timeout,";
	    } ?>
	    <?php if ($speed) {
	        echo "speed: $speed,";
	    } ?>
	    <?php if ($pause) {
	        echo "pauseOnFocus: true,";
	        echo "pauseOnHover: true,";
	        echo "pauseOnDotsHover: true,";
	    } ?>
	    <?php if ($noAnimate) {
	        echo "autoplay: false,";
	    }else{ 
	    	echo "autoplay: true,";
	    } ?>
	  responsive: [
	    {
	      breakpoint: 1140,
	      settings: {
	        slidesToShow: 6,
	        slidesToScroll: 1,
	        infinite: true,
	      }
	    },
	    {
	      breakpoint: 980,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 3,
	        infinite: true,
	      }
	    },
	    {
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 3,
	        slidesToScroll: 3,
	        infinite: true,
	      }
	    },
	    {
	      breakpoint: 480,
	      settings: {
	        slidesToShow: 2,
	        slidesToScroll: 2,
	        infinite: true,
	      }
	    }
	  ]
      });
  });
</script>

<div class="stick-image-slider-<?=$navigationTypeText; ?>" >
    <div class="plantilla-slick-c-loading" style="height:400px; text-align: center; vertical-align:center; padding-top:50px;">...</div>
    <?php if (count($rows) > 0) { ?>
        <div class="vertical-center-c slider lazy plantilla-slick-c hidden" id="stick-image-slider-<?php echo $bID; ?>">
            <?php foreach ($rows as $row) {
            ?>
                <div class="post-content-position">
                    
                    <div class="container">
	            <div class="post-content-left wp-medium-6 wpcolumns <?php if ($row['title'] || $row['description']) { }else{ echo 'hidden'; }?>">
	                <div class="recentpost-inner-content">
	                    <?php if ($row['title']) {
	                    ?>
	                    	<h2 class="wp-post-title">
	                    		<?php if ($row['linkURL']) { ?>
			                    <a href="<?php echo $row['linkURL']; ?>">
			                <?php } ?>
	                    			<?php echo $row['title']; ?>
	                    		<?php if ($row['linkURL']) { ?>
			                    </a>
			                <?php } ?>
	                    	</h2>
	                    <?php } ?>
	                    <div class="wp-post-content">
	                    	<div class="wp-sub-content">
	                    		<?php echo $row['description']; ?>
	                    	</div>	
	                    	<?php if ($row['linkURL']) { ?>
		                    <a href="<?php echo $row['linkURL']; ?>" class="readmorebtn">más información</a>
		                <?php } ?>
	                    </div>
	                </div>
	            </div>
	            </div>
	            <div class="post-image-bg">

	                <?php if ($row['linkURL']) { ?>
	                    <a href="<?php echo $row['linkURL']; ?>">
	                <?php } ?>
	                <?php
	                $f = File::getByID($row['fID']); ?>
	                <?php if (is_object($f)) {
	                    $tag = Core::make('html/image', [$f, false])->getTag();
	                    if ($row['title']) {
	                        $tag->alt($row['title']);
	                    } else {
	                        $tag->alt("slide");
	                    }
	                    echo $tag; ?>
	                <?php } ?>
	                <?php if ($row['linkURL']) { ?>
	                    </a>
	                <?php } ?>
	            </div>
                </div>
            <?php
        } ?>
        </div>
        <?php
    } else {
        ?>
        <div class="ccm-image-slider-placeholder">
            <p><?php echo t('No Slides Entered.'); ?></p>
        </div>
        <?php
    } ?>
</div>
<?php
} ?>
