<?php
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();

if (isset($currentTopic) && is_object($currentTopic)) {
    $title = t('%s', $currentTopic->getTreeNodeDisplayName());
}
if (isset($title)) {?>
	
	<?php 
		$youtube = $c->getAttribute('youtube');
		if($youtube){
		function id_youtube_A($url) {
		    $patron = '%^ (?:https?://)? (?:www\.)? (?: youtu\.be/ | youtube\.com (?: /embed/ | /v/ | /watch\?v= ) ) ([\w-]{10,12}) $%x';
		    $array = preg_match($patron, $url, $parte);
		    if (false !== $array) {
		        return $parte[1];
		    }
		    return false;
		}
		$ID_youtube = id_youtube_A($youtube);
	?>
		<iframe id="ytplayer" type="text/html" width="100%" height="480"
		src="https://www.youtube.com/embed/<?php echo $ID_youtube; ?>?autoplay=1&color=white"
		frameborder="0" allowfullscreen></iframe>
	<?php 
		}else{
	?>
		<div style="width:100%; height:400px; background-color: #CCC;"></div>
	<?php 
		}
	?>
 <?php
}
