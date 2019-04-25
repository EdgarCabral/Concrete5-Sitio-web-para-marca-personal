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

namespace Concrete\Package\AbStarRating\Block\AbStarRating;

use Concrete\Core\User\User as User;
use Concrete\Core\Block\BlockController;
use Concrete\Core\Page\Page;
use Concrete\Core\Package\Package;

class Controller extends BlockController
{
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceWidth = "700";
    protected $btInterfaceHeight = "400";
    protected $btTable = 'btAbStarRating';
    protected $btDefaultSet = 'social';
    
    protected $form_errors = array();
    protected $error_token = '';
    protected $error_register = '';
    protected $error_num_submit = '';
    protected $errors = '';

    public function getBlockTypeDescription() 
    {
        return t("Add Star Rating block");
    }

    public function getBlockTypeName() 
    {
        return t("Star Rating");
    }

    public function on_start() 
    {
        $this->set('app', $this->app);
        
        $c = Page::getCurrentPage();
        
        $this->error_token = t('Something went wrong, please try again');
        $this->error_register = t('Please log in to post rating');
        $this->error_num_submit = t('Your rating has already been posted, please wait for %s before posting another one');
        $this->errors = t('Errors found:');
    }

    public function getBlockUID($b = null) {
        if (null == $b || !is_object($b)) return null;
        $proxyBlock = $b->getProxyBlock();
        return $proxyBlock? $proxyBlock->getBlockID() : $b->bID;
    }
    
    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('javascript', 'jquery_stars');
        $this->requireAsset('css', 'font-awesome');
    }
    
    public function view()
    {
        $u = new User();
        $this->set('u', $u);
        
        $pkg = Package::getByHandle('ab_star_rating');
        $img_url = $pkg->getRelativePath() . '/blocks/ab_star_rating/images/';
        $this->set('img_url', $img_url);
        
        
        $value = $this->getAverageRating();
        $this->set('average_rating', $value);
                
        $js_data = array(
            'value' => $value,
            'size' => $this->size,
            'color' => $this->color,
            'show_star_text' => $this->show_star_text ? true : false,
            'registered' => $u->isRegistered() ? true : false,
            'error_register' => $this->error_register,
            'errors' => $this->errors,
        );
        if ($this->show_star_text) {
            $js_strings = array(
                'star1_text' => $this->star1_text,
                'star2_text' => $this->star2_text,
                'star3_text' => $this->star3_text,
                'star4_text' => $this->star4_text,
                'star5_text' => $this->star5_text,
            );
            $js_data = $js_data + $js_strings;
        }
        $this->set('js_data', json_encode($js_data, JSON_UNESCAPED_UNICODE));
    }

    public function action_rate($token = false, $bID = false) 
    {
        $data = $this->request->request->all();
        
        if ($this->bID != $bID) {
            return false;
        }
        elseif ($this->app->make('token')->validate('rate_form_'.$data['buid'], $token)) {
            if ($this->validateForm()) {
                $u = new User();
                $db = $this->app->make('database')->connection();
                
                $q = 'UPDATE btAbStarRating 
                    SET star' . $data['n'] . '_num = star' . $data['n'] . '_num + 1 
                    WHERE bID = ?';
                $v = [$this->bID];
                $db->executeQuery($q, $v);
                
                $q = 'INSERT INTO AbStarRating (uID, bID, timestamp) 
                    VALUES(?, ?, ?) 
                    ON DUPLICATE KEY UPDATE timestamp = ?';
                $v = [$u->getUserID(), $this->bID, time(), time()];
                $db->executeQuery($q, $v);
                
                echo json_encode(['status' => 'ok'], JSON_UNESCAPED_UNICODE);
            }
            else {
                echo json_encode(['status' => 'error', 'errors' => $this->form_errors], JSON_UNESCAPED_UNICODE);
            }
        }
        else {
            $this->form_errors = array();
            array_push($this->form_errors, $this->error_token);
            echo json_encode(['status' => 'error', 'errors' => $this->form_errors], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
    
    public function getAverageRating()
    {
        $db = $this->app->make('database')->connection();
        $q = 'SELECT star1_num, star2_num, star3_num, star4_num, star5_num FROM btAbStarRating WHERE bID = ?';
        $v = [$this->bID];
        $r = $db->fetchAssoc($q, $v);
        
        $rating = 0;
        if ($r['star1_num'] == 0 && $r['star2_num'] == 0 && $r['star3_num'] == 0 && $r['star4_num'] == 0 && $r['star5_num'] == 0) {
            return $rating;
        }
        else {
            $rating = ($r['star1_num'] * 1 + $r['star2_num'] * 2 + $r['star3_num'] * 3 + $r['star4_num'] * 4 + $r['star5_num'] * 5) / 
                ($r['star1_num'] + $r['star2_num'] + $r['star3_num'] + $r['star4_num'] + $r['star5_num']);
            return intval(round($rating));
        }
    }
    
    public function validateForm() 
    {
        $u = new User();
        if (!$u->isRegistered()) {
            array_push($this->form_errors, $this->error_register);
            return false;
        }
        
        $db = $this->app->make('database')->connection();
        $q = 'SELECT timestamp FROM AbStarRating WHERE uID = ? AND bID = ? ORDER BY timestamp';
        $v = [$u->getUserID(), $this->bID];
        $r = $db->fetchAssoc($q, $v);
        
        $config_database = $this->app->make('config/database');
        $min_wait = $config_database->get('ab_star_rating.min_wait');
        $wait = $min_wait . ' ' . t('seconds');
        if ($min_wait > 60 && $min_wait <= 3600) {
            $wait = ceil($min_wait / 60) . ' ' . t('minutes');
        }
        elseif ($min_wait > 3600) {
            $wait = ceil($min_wait / 3600) . ' ' . t('hours');
        }
        
        if ($r && (time() - $r['timestamp']) < $min_wait) {
            array_push($this->form_errors, sprintf($this->error_num_submit, $wait));
        }
        
        if (!$this->form_errors) {
            return true;
        }
        else {
            return false;
        }
    }
    
    public function save($args)
    {
        $args['star1_num'] = is_null($this->star1_num) ? 0 : $args['star1_num'];
        $args['star2_num'] = is_null($this->star2_num) ? 0 : $args['star2_num'];
        $args['star3_num'] = is_null($this->star3_num) ? 0 : $args['star3_num'];
        $args['star4_num'] = is_null($this->star4_num) ? 0 : $args['star4_num'];
        $args['star5_num'] = is_null($this->star5_num) ? 0 : $args['star5_num'];
        
        $args['size'] = isset($args['size']) ? $args['size'] : 1;
        $args['color'] = isset($args['color']) ? $args['color'] : '#0099ff';
        $args['show_av_rating'] = isset($args['show_av_rating']) ? 1 : 0;
        $args['show_star_text'] = isset($args['show_star_text']) ? 1 : 0;
        $args['star1_text'] = $args['show_star_text'] ? $args['star1_text'] : null;
        $args['star2_text'] = $args['show_star_text'] ? $args['star2_text'] : null;
        $args['star3_text'] = $args['show_star_text'] ? $args['star3_text'] : null;
        $args['star4_text'] = $args['show_star_text'] ? $args['star4_text'] : null;
        $args['star5_text'] = $args['show_star_text'] ? $args['star5_text'] : null;
        parent::save($args);
    }

    public function validate($args)
    {
        $e = $this->app->make('helper/validation/error');
        
        $size = trim($args['size']);
        if (!filter_var($size, FILTER_VALIDATE_FLOAT) || (float)$size < 0.7 || (float)$size > 2.0) {
            $e->add(t('Size must be decimal value from 0.7 to 2'));
        }

        return $e;
    }

}
