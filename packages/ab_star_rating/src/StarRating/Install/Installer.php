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

class Installer extends BaseClass
{
    protected $installers;
    
    public function __construct($pkg)
    {
        parent::__construct($pkg);

        $this->installers = [
            new SinglePages($this->pkg),
            new DefaultConfigValues($this->pkg),
            new Blocks($this->pkg),
        ];
    }
    
    public function install()
    {
        foreach ($this->installers as $installer) {
            $installer->install();
        }
    }
}
