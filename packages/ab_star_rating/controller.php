<?php

/**
 * Star Rating package for Concrete5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Alex Borisov <linuxoidoz@gmail.com>
 * @copyright 2017-2018, Alex Borisov
 * @package Concrete\Package\ab_star_rating
 */
 
namespace Concrete\Package\AbStarRating;

use Concrete\Core\Package\Package;
use Concrete\Core\Asset\Asset;
use Concrete\Core\Asset\AssetList;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;

use StarRating\Install\Installer;

class Controller extends Package {

    protected $pkgHandle = 'ab_star_rating';
    protected $appVersionRequired = '8.3.2';
    protected $pkgVersion = '1.0.1';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = [
        'src/StarRating' => 'StarRating'
    ];
	
    public function getPackageDescription() 
    {
        return t('Add Star Rating package');
    }
    
    public function getPackageName() 
    {
        return t("Star Rating");
    }
    
    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/StarRating' => 'StarRating'
        ]);
        return $provider;
    }
    
    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register('javascript', 'jquery_stars', 'js/jquery_stars.js', array('version' => '1', 'position' => Asset::ASSET_POSITION_FOOTER, 'minify' => false, 'combine' => false), $this);
    }
    
    public function install() 
    {
        $pkg = parent::install();
        $installer = new Installer($pkg);
        $installer->install();
    }
    
    public function uninstall() 
    {
        parent::uninstall();
        
        $db = $this->app->make('database')->connection();
        $q = 'DROP TABLE IF EXISTS btAbStarRatingSpam';
        $v = [''];
        $db->executeQuery($q, $v);
    }
}
