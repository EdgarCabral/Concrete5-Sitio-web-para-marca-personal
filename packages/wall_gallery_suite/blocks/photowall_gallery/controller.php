<?php  
namespace Concrete\Package\WallGallerySuite\Block\PhotowallGallery;
use \Concrete\Core\Block\BlockController;
use Database;
use Loader;
use \File;
use FileSet;
use FileList;
use BlockType;
use Page;
use Core;
use \Concrete\Core\Block\View\BlockView as BlockView;
use Concrete\Core\File\Type\Type as FileType;

defined('C5_EXECUTE') or die("Access Denied."); 
class Controller extends BlockController
{
    protected $btTable = 'btPhotowallGallery';
    protected $btInterfaceWidth = "600";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "445";
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
	protected $btDefaultSet = 'multimedia';

    public function getBlockTypeDescription()
    {
        return t("A responsive justified image gallery.");
    }

    public function getBlockTypeName()
    {
        return t("Photowall Gallery");
    }
    
    function add() {
        $this->set('fsID', 0);
        $this->loaders();
    }
    
    function edit() {
        $this->loaders();
    }
    function loaders()
    {
        $sets = FileSet::getMySets();
        $this->set("sets",$sets);
        
        $this->requireAsset('core/file-manager');
        
        $uh = Loader::helper('concrete/urls');
        $bt = BlockType::getByHandle('photowall_gallery');
        $toolsURL = $uh->getBlockTypeToolsURL($bt);
        $this->set("toolsURL",$toolsURL."/get_thumbs");
    }
    function view(){
        $fsID = $this->fileset;
        $bID = $this->bID;
        $db = Database::connection();
        $existingThumbs = $db->GetAll('SELECT * from btPhotowallGalleryThumb WHERE bID = ? ORDER BY sort', array($bID)); //gives us all the files we've already saved/sorted
        $existingThumbIDs = array();
        foreach($existingThumbs as $thumb){
            $existingThumbIDs[] = $thumb['fID'];
        }
        
        $fs = FileSet::getByID($fsID);
        $fileList = new FileList();            
        $fileList->filterBySet($fs);
        $fileList->filterByType(FileType::T_IMAGE);
        $fileList->sortByFileSetDisplayOrder();
        $files = $fileList->get(); //gives us all the files in the set
        
        //we're going to make a new array of thumbs from the files in our fileset.
        $allThumbs = array();
        foreach($files as $file){
            if(in_array($file->getFileID(),$existingThumbIDs)){
                $sort = $db->GetOne('SELECT sort from btPhotowallGalleryThumb WHERE bID = ? and fID = ?', array($bID,$file->getFileID()));
                $thumb = array('fID'=>$file->getFileID(),'sort'=>$sort);
            } else{
                $thumb = array('fID'=>$file->getFileID(),'sort'=>9999);
            }
            $allThumbs[] = $thumb;
        }   
        $allThumbs = $this->thumbSort($allThumbs,'sort',SORT_ASC);
        $this->set("items",$allThumbs);
    }
    public function save($args)
    {
        $db = Database::connection();
        $db->executeQuery('DELETE from btPhotowallGalleryThumb WHERE bID = ?', array($this->bID));
        $count = count($args['sort']);
        $i = 0;
        parent::save($args);
        while ($i < $count) {
            $vals = array($this->bID,$args['fID'][$i],$args['sort'][$i]);     
            $db->executeQuery('INSERT INTO btPhotowallGalleryThumb (bID,fID, sort) values(?,?,?)', $vals);
            $i++;
        }
        $blockObject = $this->getBlockObject();
        if (is_object($blockObject)) {
            $blockObject->setCustomTemplate($args['zoomType']);
        }
    }
    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Database::connection();
        $vals = array($this->bID);
        $data = $db->query('SELECT * FROM btPhotowallGalleryThumb WHERE bID = ?', $vals);
        while ($row = $data->FetchRow()) {
            $vals = array($newBID,$row['fID'],$row['sort']);
            $db->executeQuery('INSERT INTO btPhotowallGalleryThumb (bID, fID, sort) values(?,?,?)', $vals);
        }
    }
    public function validate($args)
    {
        $e = Core::make("helper/validation/error");       
        if(empty($args['rowHeight'])){
            $e->add(t("Row Height must be set."));
        }
        if(!ctype_digit(trim($args['rowHeight']))){
            $e->add(t("Row Height must be numeric only."));
        }
        if(empty($args['maxRowHeight'])){
            $e->add(t("Max Row Height must be set"));
        }
        if(!ctype_digit(trim($args['maxRowHeight']))){
            $e->add(t("Max Row Height must be numeric only."));
        }
		if(empty($args['margins'])){
			$e->add(t("Margins must be set."));
		}
		if(!ctype_digit(trim($args['margins']))){
			$e->add(t("Margins must be numeric only."));
		}
		if(empty($args['hideBarsDelay'])){
			$e->add(t("Hide Bars Delay must be set."));
		}
		if(!ctype_digit(trim($args['hideBarsDelay']))){
			$e->add(t("Hide Bars Delay must be numeric only."));
		}
        return $e;
    }
	
	public function registerViewAssets($outputContent = '') {
		$this->requireAsset('javascript','photowall-gal');
		$this->requireAsset('javascript','photowall-swipe');
	}
	
    function thumbSort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
    
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
    
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }
    
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
    
        return $new_array;
    }
    
}