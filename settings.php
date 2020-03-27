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
 * Admin settings and defaults.
 *
 * @package auth_unmulsia
 * @copyright  Agus Tri Haryono
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $settings->add(new admin_setting_configtext('auth_unmulsia/serverurllogin',
                                                get_string('serverurllogin', 'auth_unmulsia'),
                                                get_string('serverurllogin_desc', 'auth_unmulsia'),
                                                '', PARAM_TEXT));

    $settings->add(new admin_setting_configtext('auth_unmulsia/serverurldata',
                                                get_string('serverurldata', 'auth_unmulsia'),
                                                get_string('serverurldata_desc', 'auth_unmulsia'),
                                                '', PARAM_TEXT));

    $settings->add(new admin_setting_configtext('auth_unmulsia/changepasswordurl',
                                                get_string('changepasswordurl', 'auth_unmulsia'),
                                                get_string('changepasswordurl_desc', 'auth_unmulsia'),
                                                '', PARAM_TEXT));

    $deleteopt = array();
    $deleteopt[AUTH_REMOVEUSER_KEEP] = get_string('auth_remove_keep', 'auth');
    $deleteopt[AUTH_REMOVEUSER_SUSPEND] = get_string('auth_remove_suspend', 'auth');
    $deleteopt[AUTH_REMOVEUSER_FULLDELETE] = get_string('auth_remove_delete', 'auth');

    $settings->add(new admin_setting_configselect('auth_unmulsia/removeuser',
        new lang_string('auth_remove_user_key', 'auth'),
        new lang_string('auth_remove_user', 'auth'), AUTH_REMOVEUSER_KEEP, $deleteopt));
}
