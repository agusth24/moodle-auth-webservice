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
 * Anobody can login with any password.
 *
 * @package auth_unmulsia
 * @author Agus Tri Haryono
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

/**
 * Plugin for no authentication.
 */
class auth_plugin_unmulsia extends auth_plugin_base {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->authtype = 'unmulsia';
        $this->config = get_config('auth_unmulsia');
    }

    /**
     * Old syntax of class constructor. Deprecated in PHP7.
     *
     * @deprecated since Moodle 3.1
     */
    public function auth_plugin_unmulsia() {
        debugging('Use of class name as constructor is deprecated', DEBUG_DEVELOPER);
        self::__construct();
    }

    /**
     * Returns true if the username and password work or don't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    function user_login ($username, $password) {
        
        $params_MHS = array(
                        'userid' => $username,
                        'password' => $password,
                        'usertype' => 'MHS' 
                        );
        $result_MHS = $this->call_ws($this->config->serverurl,$params_MHS);

        $params_DSN = array(
                        'userid' => $username,
                        'password' => $password,
                        'usertype' => 'DSN' 
                        );
        $result_DSN = $this->call_ws($this->config->serverurl,$params_DSN);

        if(isset($result_MHS->sessionId) or isset($result_DSN->sessionId))
            return true;
        else
            return false;
    }

    private function call_ws($serverurl, $params = array()) {

        $url = $serverurl; 
        $data = json_encode($params);


        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,$url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);

        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
         
        $result = json_decode($buffer);

        return  $result ;
    
    }

    /**
    * This plugin is intended only to authenticate users.
    * User synchronization must be done by external service,
    * using Moodle's webservices.
    *
    * @param progress_trace $trace
    * @param bool $doupdates  Optional: set to true to force an update of existing accounts
    * @return int 0 means success, 1 means failure
    */
    public function sync_users(progress_trace $trace, $doupdates = false) {
        return true;
    }

    public function get_userinfo($username) {
        return array();
    }

    public function is_synchronised_with_external() {
        return false;
    }

    function prevent_local_passwords() {
        return true;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return false;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    function change_password_url() {
        if (isset($this->config->changepasswordurl) && !empty($this->config->changepasswordurl)) {
            return new moodle_url($this->config->changepasswordurl);
        } else {
            return null;
        }
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return false;
    }

    /**
     * Returns true if plugin can be manually set.
     *
     * @return bool
     */
    function can_be_manually_set() {
        return true;
    }

}


