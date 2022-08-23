<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


namespace local_usergenerator\form;

use coding_exception;
use moodleform;

/**
 * local_usergenerator moodleform for
 * user generator initial data
 *
 * @package    local_usergenerator
 * @copyright  2022 rajaazian <rajaazian08@gmai.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class usergenerator_form extends moodleform
{

    /**
     * Moddle form definitio
     *
     * @return void
     * @throws coding_exception
     */
    protected function definition(): void
    {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('header', 'usergeneratorinformation', get_string('informations', 'local_usergenerator'));

        $mform->addElement('text', 'prefix', get_string('prefix', 'local_usergenerator'));
        $mform->setType('prefix', PARAM_TEXT);
        $mform->addHelpButton('prefix', 'prefix', 'local_usergenerator');
        $mform->addRule('prefix', get_string('cannotbeempty', 'local_usergenerator'), 'required', '');
        $mform->addRule('prefix', get_string('cannotmorethan', 'local_usergenerator', '5 characters'), 'maxlength', '5');

        $mform->addElement('text', 'count', get_string('count', 'local_usergenerator'));
        $mform->setType('count', PARAM_TEXT);
        $mform->addHelpButton('count', 'count', 'local_usergenerator');
        $mform->addRule('count', get_string('cannotbeempty', 'local_usergenerator'), 'required', '');
        $mform->addRule('count', get_string('mustbetypeofnumber', 'local_usergenerator'), 'numeric', '');
        $mform->addRule('count', get_string('cannotmorethan', 'local_usergenerator', '99'), 'maxlength', '2');

        $mform->closeHeaderBefore('usergeneratorinformation');

        $this->add_action_buttons();
    }
}