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

/**
 * Form view page to set criteria
 * of generated user
 *
 * @package    local_usergenerator
 * @copyright  2022 rajaazian <rajaazian08@gmai.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('local_usergenerator');

// Set up the page.
$title = get_string('pluginname', 'local_usergenerator');
$pagetitle = $title;
$url = new moodle_url("/local/usergenerator/index.php");
$PAGE->set_url($url);
$PAGE->set_title("$SITE->shortname: Administrations: Plugins: Local Plugins: $title");
$PAGE->set_heading($title);
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_cacheable(false);

$mform = new \local_usergenerator\form\usergenerator_form();

echo $OUTPUT->header();
echo $OUTPUT->heading($pagetitle);

if ($mform->is_cancelled()) {
    $mform->display();
} else if ($fromform = $mform->get_data()) {
    \local_usergenerator\helper\generate_user::process($fromform);
    \core\notification::success(get_string('usercreatedsuccessfully', 'local_usergenerator'));
    $mform->display();
} else {
    $mform->display();
}

echo $OUTPUT->footer();