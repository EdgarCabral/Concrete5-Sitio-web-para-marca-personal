<?php 
namespace Concrete\Package\RonydSearch;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends \Concrete\Core\Package\Package {

	protected $pkgHandle = 'ronyd_search';
	protected $appVersionRequired = '5.7.2';
	protected $pkgVersion = '2.0';
	
	public function getPackageName() {
		return t('Ronyd Expanded Search Bar');
	}	
	
	public function getPackageDescription() {
		return t('Add stylish expanding search bar anywhere in website.');
	}
	
	public function install() {
		$pkg = parent::install();
	}
	
}