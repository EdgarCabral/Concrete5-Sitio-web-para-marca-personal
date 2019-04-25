<?php 
namespace Concrete\Package\CallToAction\Block\CallToAction;

use Concrete\Core\Block\BlockController;
use Loader;
use Less_Parser;
use Less_Tree_Rule;
use Core;
use Page;

defined('C5_EXECUTE') or die("Access Denied.");

class Controller extends BlockController {
 
	protected $btTable = 'btCallToAction';
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "500";
	protected $btWrapperClass = 'ccm-ui';
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
		
	public function getBlockTypeName() {
		return t("Call to Action");
	}	
	public function getBlockTypeDescription() {
		return t("Add a call to action to your concrete5 website");		
	}
		
	public function getSearchableContent(){
		return $this->callToActionText.' '.$this->callToActionLinkText;
	}

	public function getBlockTypeHelp() {
		return t('For more concrete5 Themes & Add-ons please check out <a href="http://c5hub.com/store" title="concrete5 Themes & Add-ons" target="_blank">c5Hub</a>.');
	}	

	function getExternalLink() {return $this->externalLink;}
	function getInternalLinkCID() {return $this->internalLinkCID;}
	function getLinkURL() {
		if (!empty($this->externalLink)) {
			return $this->externalLink;
		} else if (!empty($this->internalLinkCID)) {
			$linkToC = Page::getByID($this->internalLinkCID);
			return (empty($linkToC) || $linkToC->error) ? '' : Loader::helper('navigation')->getLinkToCollection($linkToC);
		} else {
			return '';
		}
	}

    public function on_start() {
		$this->requireAsset('css', 'font-awesome');
        $this->requireAsset('javascript', 'jquery');		
	}
	
	public function add() {
		$this->edit();
		$this->set('callToActionTextColor', 'rgb(255, 255, 255)');
		$this->set('callToActionLinkTextColor', 'rgb(255, 255, 255)');
		$this->set('callToActionButtonColor', 'rgb(60, 154, 95)');
		$this->set('callToActionBackgroundColor', 'rgb(67, 90, 107)');
	}
	
	public function view(){

        if($this->callToActionTextColor) {
			$textColor = $this->callToActionTextColor;
			$textColor = ' style="color:'.$textColor.'"';
			$this->set('textColor', $textColor);
        }

        if($this->callToActionText) {
			$text = '<span class="c5h-call-to-action-text"'.$textColor.'>'.$this->callToActionText.'</span>';
			$this->set('text', $text);
        }
        
        if($this->callToActionLinkTextColor) {
			$linkTextColor = $this->callToActionLinkTextColor;
			$linkTextColor = ' style="color:'.$linkTextColor.'"';
			$this->set('linkTextColor', $linkTextColor);
        }

        if($this->callToActionButtonColor) {
			$buttonColor = $this->callToActionButtonColor;
			$buttonColor = ' style="background-color:'.$buttonColor.'"';
			$this->set('buttonColor', $buttonColor);
        }

        if($this->callToActionFonticon) {
			$icon = $this->callToActionFonticon;
			$icon = '<i style="color:'.$this->callToActionFonticonColor.';" class="fa fa-'.$this->callToActionFonticon.'"></i> ';
			$this->set('icon', $icon);
        }
                
        if($this->callToActionLinkText) {
			$button = '<a href="'.$this->getLinkURL().'"><span class="c5h-call-to-action-button"'.$buttonColor.'><span'.$linkTextColor.'>'.$icon.$this->callToActionLinkText.'</span></span></a>';
			$this->set('button', $button);
        }
        
        if($this->callToActionBackgroundColor) {
			$backgroundColor = $this->callToActionBackgroundColor;
			$backgroundColor = ' style="background-color:'.$backgroundColor.';"';
			$this->set('backgroundColor', $backgroundColor);
        }        
	}

    protected function getIconClasses() {
        $iconLessFile = DIR_BASE_CORE . '/css/build/vendor/font-awesome/variables.less';
        $icons = array();

        $l = new Less_Parser();
        $parser = $l->parseFile($iconLessFile, false, true);
        $rules = $parser->rules;

        foreach($rules as $rule) {
            if ($rule instanceof Less_Tree_Rule) {
                if (strpos($rule->name, '@fa-var') === 0) {
                    $name = str_replace('@fa-var-', '', $rule->name);
                    $icons[] = $name;
                }
            }
        }
        asort($icons);
        return $icons;
    }

    public function edit() {
        $classes = $this->getIconClasses();

        // let's clean them up
        $icons = array('' => t('Choose Icon'));
        $txt = Core::make('helper/text');
        foreach($classes as $class) {
            $icons[$class] = $txt->unhandle($class);
        }
        $this->set('icons', $icons);
        
		$this->requireAsset('core/file-manager');
    }

	public function save($args) {
		switch (intval($args['linkType'])) {
			case 1:
				$args['externalLink'] = '';
				break;
			case 2:
				$args['internalLinkCID'] = 0;
				break;
			default:
				$args['externalLink'] = '';
				$args['internalLinkCID'] = 0;
				break;
		}
		unset($args['linkType']); //this doesn't get saved to the database (it's only for UI usage)		
		parent::save($args);
	}
}
?>