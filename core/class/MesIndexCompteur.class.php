<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class MesIndexCompteur extends eqLogic {
    public static $_widgetPossibility = array('custom' => array(
        'visibility' => true,
        'displayName' => array('dashboard' => true, 'view' => true),
        'optionalParameters' => true,
    ));
}

class MesIndexCompteurCmd extends cmd {
    public function execute($_options = array()) {
        if ($this->getType() == 'info') {
            return;
        }

        $eqLogic = $this->getEqLogic();
        if ($this->getLogicalId() == 'NewIndex') {
            log::add('MesIndexCompteur', 'debug', $_options['val']);

            $lastIndexCmd = $eqLogic->getCmd(null, 'LastIndex'); 
            $newIndex = $_options['val'];
            $lastIndexCmd->event($newIndex);

            $deltaIndexCmd = $eqLogic->getCmd(null, 'DeltaIndex');
            // Reference
            $lastIndex = $eqLogic->getConfiguration('lastIndex');
            if($lastIndex == '')
            {
                $lastIndex = 0;
            }

            $deltaIndexCmd->event($newIndex - $lastIndex);

            $eqLogic->refreshWidget();
        }
    }
}