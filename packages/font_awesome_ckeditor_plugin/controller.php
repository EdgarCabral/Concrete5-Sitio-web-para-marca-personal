<?php
namespace Concrete\Package\FontAwesomeCkeditorPlugin;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\Plugin;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Events;

class Controller extends Package
{
    protected $pkgHandle = 'font_awesome_ckeditor_plugin';
    protected $appVersionRequired = '8.2.1';
    protected $pkgVersion = '0.9.1';

    public function getPackageName()
    {
        return t('Font Awesome Font Icons for CKEditor');
    }

    public function getPackageDescription()
    {
        return t('Add Font Awesome icons in the CKEditor rich text editor.');
    }

    public function on_start()
    {
        $this->registerPlugin();

        Events::addListener('on_before_render', function () {
            $responseAssetGroup = ResponseAssetGroup::get();
            $responseAssetGroup->requireAsset('css', 'font-awesome');
        });
    }

    protected function registerPlugin()
    {
        $assetList = AssetList::getInstance();

        $assetList->register(
            'javascript',
            'editor/ckeditor/ckawesome',
            'assets/ckawesome/register.js',
            [],
            $this->pkgHandle
        );

        $assetList->registerGroup(
            'editor/ckeditor/ckawesome',
            [
                ['javascript', 'editor/ckeditor/ckawesome']
            ]
        );

        $plugin = new Plugin();
        $plugin->setKey('ckawesome');
        $plugin->setName(t('Font Awesome Font Icons for CKEditor'));
        $plugin->requireAsset('editor/ckeditor/ckawesome');

        $this->app->make('editor')->getPluginManager()->register($plugin);
    }
}
