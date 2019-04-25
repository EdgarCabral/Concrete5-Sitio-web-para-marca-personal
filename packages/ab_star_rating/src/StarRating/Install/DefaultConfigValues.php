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

namespace StarRating\Install;

class DefaultConfigValues extends BaseClass
{
    public function install()
    {
        $this->setDefaultConfigValues();
    }

    private function setDefaultConfigValues()
    {
        $this->setConfigValue('ab_star_rating.min_wait', 86400);
    }
    
    private function setConfigValue($key, $value)
    {
        $config_database = $this->app->make('config/database');
        $config = $config_database->get($key);
        if (empty($config)) {
            $config_database->save($key, $value);
        }
    }
}
