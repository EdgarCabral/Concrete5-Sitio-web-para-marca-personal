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

namespace Concrete\Package\AbStarRating\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

class StarRatingSettings extends DashboardPageController
{
    public function on_start() {
        $this->set('app', $this->app);
    }
        
    public function success()
    {
        $this->set('success', t('Settings Saved'));
    }

    public function save()
    {
        $data = $this->request->request->all();

        if ($data) {
            $errors = $this->validate($data);
            $this->error = null; //clear errors
            $this->error = $errors;
            if (!$errors->has()) {
                $config_database = $this->app->make('config/database');
                
                $config_database->save('ab_star_rating.min_wait', ($data['min_wait'] == '' || $data['min_wait'] == 0) ? 0 : $data['min_wait']);
                
                $r = Redirect::to('/dashboard/star_rating_settings/success');
                $r->send();
                exit;
            }
        }
    }
    
    public function validate($data)
    {
        $e = $this->app->make('helper/validation/error');
        
        $min_wait = trim($data['min_wait']);
        if ((int)$min_wait > 86400) {
            $e->add(t('Min wait must be integer < 86400'));
        }

        return $e;
    }

}
