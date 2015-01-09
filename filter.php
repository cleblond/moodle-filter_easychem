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
 * Filter converting URLs in the text to HTML links
 *
 * @package    filter
 * @subpackage easychem
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class filter_easychem extends moodle_text_filter {

    protected static $globalconfig;
    /**
     * Apply the filter to the text
     *
     * @see filter_manager::apply_filter_chain()
     * @param string $text to be processed by the text
     * @param array $options filter options
     * @return string text after processing
     */
    public function filter($text, array $options = array()) {
        global $CFG, $PAGE, $easychemconfigured;
        $search = "(\[\%(.*?)\\%])is";
        $newtext = preg_replace_callback($search, array($this, 'callback'), $text);
        if (($newtext != $text) && !isset($easychemconfigured)) {
            $easychemconfigured = true;
            $url = $CFG->wwwroot . '/filter/easychem/js/easychem.js';
            $url = new moodle_url($url);
            $moduleconfig = array(
                'name' => 'easychem',
                'fullpath' => $url
            );
            $PAGE->requires->js_module($moduleconfig);
            $PAGE->requires->yui_module('moodle-filter_easychem-loader', 'M.filter_easychem.typeset');
        }
        return $newtext;
    }

    private function callback(array $matches) {
        global $CFG, $PAGE;
        $embed = '<div class="echem-formula" align="center">'.$matches[1].'</div>';
        return $embed;
    }
}
