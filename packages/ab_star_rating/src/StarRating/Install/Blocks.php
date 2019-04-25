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

use Concrete\Core\Block\BlockType\BlockType;

class Blocks extends BaseClass
{
    public function __construct($pkg)
    {
        parent::__construct($pkg);
    }

    public function install()
    {
        $this->installBlocks($this->pkg);
    }

    private function installBlocks($pkg)
    {
        $this->installBlock('ab_star_rating', $pkg);
    }
    
    private function installBlock($handle, $pkg)
    {
        $blockType = BlockType::getByHandle($handle);
        if (!is_object($blockType)) {
            BlockType::installBlockType($handle, $pkg);
        }
    }
}
