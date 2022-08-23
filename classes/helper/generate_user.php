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

namespace local_usergenerator\helper;

use dml_exception;
use dml_transaction_exception;
use stdClass;

/**
 * local_usergenerator helper class
 * for generate users
 *
 * @package    local_usergenerator
 * @copyright  2022 rajaazian <rajaazian08@gmai.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generate_user
{
    /**
     * Default password for
     * generated users
     * @var string
     */
    protected static $PASSWORD = 'Password@12345';


    /**
     * Entry function to
     * generate users
     *
     * @param $formdata
     * @return void
     * @throws dml_exception
     * @throws dml_transaction_exception
     */
    public static function process($formdata): void
    {
        global $DB;

        $prefix = $formdata->prefix;
        $total = $formdata->count;

        $transaction = $DB->start_delegated_transaction();

        for ($i = 0; $i < $total; $i++) {
            $email = self::generate_email($prefix, $i);
            $username = self::generate_username($prefix, $i);
            if (!self::is_user_exist($email, $username)) {
                $currentuser = create_user_record($username, self::$PASSWORD);
                $newuser = self::construct_userdata($email, $prefix, $i);
                $currentuser->email = $newuser->email;
                $currentuser->firstname = $newuser->firstname;
                $currentuser->lastname = $newuser->lastname;
                $DB->update_record('user', $currentuser);
            }
        }

        $transaction->allow_commit();
    }

    /**
     * Check if generated user
     * exist in database
     *
     * @param string $email
     * @param string $username
     * @return bool
     * @throws dml_exception
     */
    private static function is_user_exist(string $email, string $username): bool
    {
        global $DB;

        $emailcheck = $DB->get_record('user', [
            'email' => $email
        ]);

        $usernamecheck = $DB->get_record('user', [
            'username' => $username
        ]);

        if ($emailcheck || $usernamecheck) {
            return true;
        }
        return false;
    }

    /**
     * Generate username
     *
     * @param string $prefix
     * @param int $count
     * @return string
     */
    private static function generate_username(string $prefix, int $count): string
    {
        $padnum = self::padded_number($count);
        return $prefix . $padnum;
    }

    /**
     * Generate email
     *
     * @param string $prefix
     * @param int $count
     * @return string
     */
    private static function generate_email(string $prefix, int $count): string
    {
        $padnum = self::padded_number($count);
        return $prefix . $padnum . '@mail.test';
    }

    /**
     * Padding number for generate
     * email and username
     *
     * @param int $number
     * @return string
     */
    private static function padded_number(int $number): string
    {
        return sprintf("%04d", $number);
    }

    /**
     * Construct user class object
     *
     * @param string $email
     * @param string $prefix
     * @param int $count
     * @return stdClass
     */
    private static function construct_userdata(string $email, string $prefix, int $count): stdClass
    {
        $newuser = new stdClass();
        $newuser->email = $email;
        $newuser->firstname = $prefix;
        $newuser->lastname = self::padded_number($count);
        return $newuser;
    }
}
