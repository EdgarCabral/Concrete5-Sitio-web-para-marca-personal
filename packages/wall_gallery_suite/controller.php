<?php        
namespace Concrete\Package\WallGallerySuite;
use Package;
use BlockType;
use AssetList;
use \Concrete\Core\Asset\Asset;
use Core;
use Database;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends Package {

	protected $pkgHandle = 'wall_gallery_suite';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0.1';
	
	
	public function getPackageDescription() {
		return t("Three responsive image galleries in one package.");
	}

	public function getPackageName() {
		return t("Wall Gallery Suite");
	}
	
	public function on_start() {
		$al = AssetList::getInstance();
		$al->register(
	 		'javascript', 'photowall-gal', 'blocks/photowall_gallery/js/photowall/jquery.justifiedGallery.min.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
		$al->register(
			'javascript', 'photowall-swipe', 'blocks/photowall_gallery/js/photowall/jquery.swipebox.min.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
		$al->register(
			'javascript', 'imagewall-js', 'blocks/image_wall/js/imagewall/imagewall.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
		$al->register(
			'javascript', 'imagewall-easing', 'blocks/image_wall/js/imagewall/jquery.easing.1.3.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
		$al->register(
			'javascript', 'imagewall-masonry', 'blocks/image_wall/js/imagewall/jquery.masonry.min.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
		$al->register(
			'javascript', 'wallgallery', 'blocks/wall_gallery/js/wallgallery/lightGallery.min.js',
	 		array('version' => '1.0.0', 'position' => Asset::ASSET_POSITION_HEADER, 'minify' => false, 'combine' => false), $this
	 	);
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('photowall_gallery', $pkg); 
        BlockType::installBlockTypeFromPackage('image_wall', $pkg);
		BlockType::installBlockTypeFromPackage('wall_gallery', $pkg);
	}
    public function uninstall() 
    {
        parent::uninstall();
        $db = Database::connection();
        $db->executeQuery('DROP TABLE btPhotowallGallery, btPhotowallGalleryThumb, btImageWall, btImageWallThumb, btWallGallery, btWallGalleryThumb');
    }
}
?>