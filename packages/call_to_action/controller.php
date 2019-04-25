<?php 
namespace Concrete\Package\CallToAction;
use Package;
use BlockType;
use Loader;

class Controller extends Package {

	protected $pkgHandle = 'call_to_action';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0.0';

	public function getPackageName() {
		return t("Call to Action");
	}
	
	public function getPackageDescription() {
		return t("Add a call to action to your concrete5 website");
	}
 
	public function install() {
		$pkg = parent::install();
		
		// Install Block
		if(!BlockType::getByHandle('call_to_action')) {
			BlockType::installBlockTypeFromPackage('call_to_action', $pkg);
		}
	}
}
?>