<?php    
namespace Concrete\Package\MacyMasonryPagelist;

class Controller extends \Concrete\Core\Package\Package {

	protected $pkgHandle = 'macy_masonry_pagelist';
	protected $appVersionRequired = '5.7.2';
	protected $pkgVersion = '1.0';
	
	public function getPackageName() {
		return t('Pagelist - masonry custom template');
	}	
	
	public function getPackageDescription() {
		return t('Custom template for pagelist block based on macy.js. macy.js is lightweight javaScript library designed to create masonry layout. Responsive - User definable breakpoints.');
	}
	
	public function install() {
		$pkg = parent::install();
	}
	
}


