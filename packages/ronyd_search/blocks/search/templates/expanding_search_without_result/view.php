<?php      defined('C5_EXECUTE') or die("Access Denied."); 

if( strlen($title)>0 ){
	$placeholder = $title;
} else {
	$placeholder =  t('Buscar en el sitio...');
}
?>

<?php      if (isset($error)) { ?>
	<?php      echo $error?><br/><br/>
<?php      } ?>

<div id="sb-search<?php     echo $bID?>" class="sb-search without_res">
						
<form action="<?php      echo $this->url( $resultTargetURL )?>" method="get" class="ccm-search-block-form">
	
	<?php      if(strlen($query)==0){ ?>
	<input name="search_paths[]" type="hidden" value="<?php      echo htmlentities($baseSearchPath, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php      } else if (is_array($_REQUEST['search_paths'])) { 
		foreach($_REQUEST['search_paths'] as $search_path){ ?>
			<input name="search_paths[]" type="hidden" value="<?php      echo htmlentities($search_path, ENT_COMPAT, APP_CHARSET) ?>" />
	<?php       }
	} ?>
	
	<input name="query" type="text" value="<?php      echo htmlentities($query, ENT_COMPAT, APP_CHARSET)?>" placeholder="<?php      echo $placeholder?>" class="sb-search-input ccm-search-block-text" autocomplete="off" />
	
	<input name="submit" type="submit" value="<?php      echo $buttonText?>" class="sb-search-submit ccm-search-block-submit" />
	<span class="sb-icon-search"></span>
    
</form>

</div>  

<script type="text/javascript">
	$(document).ready(function(){
		new UISearch( document.getElementById( 'sb-search<?php     echo $bID?>' ) );
	});
</script>