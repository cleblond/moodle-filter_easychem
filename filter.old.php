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

     /**
      * @var array global configuration for this filter
      *
      * This might be eventually moved into parent class if we found it
      * useful for other filters, too.
      */
    protected static $globalconfig;



    /*
     * Add the javascript to enable mathjax processing on this page.
     *
     * @param moodle_page $page The current page.
     * @param context $context The current context.
     */
    public function setup($page, $context) {
        global $CFG;
        // This only requires execution once per request.
        static $jsinitialised = false;

        if (empty($jsinitialised)) {
           /* if (strpos($CFG->httpswwwroot, 'https:') === 0) {
                $url = get_config('filter_easychem', 'httpsurl');
            } else {
                $url = get_config('filter_easychem', 'httpurl');
            }*/
            //$lang = $this->map_language_code(current_language());

            //$protocol = (empty($_SERVER['HTTPS']) or $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://';
            $url = $CFG->wwwroot . '/filter/easychem/js/easychem.js';

            //$url = 'http://localhost/moodle27/filter/easychem/js/easychem.js';
            $url = new moodle_url($url);

            $moduleconfig = array(
                'name' => 'easychem',
                'fullpath' => $url
            );

            $page->requires->js_module($moduleconfig);

/*
            $url = 'http://localhost/moodle27/filter/easychem/js/jquery-latest.js';
            $url = new moodle_url($url);

            $moduleconfig2 = array(
                'name' => 'jquery',
                'fullpath' => $url
            );

            $page->requires->js_module($moduleconfig2);
*/
	    $page->requires->yui_module('moodle-filter_easychem-loader', 'M.filter_easychem.typeset');

            $config = get_config('filter_easychem', 'mathjaxconfig');
            $lang = 'en';
            //print_object($config);
            $params = array('mathjaxconfig' => $config, 'lang' => $lang);
//            $page->requires->jquery();
//            $page->requires->yui_module('moodle-filter_easychem-loader', 'M.filter_easychem.configure', array($params));

            $jsinitialised = true;
        }
    }


    /**
     * Apply the filter to the text
     *
     * @see filter_manager::apply_filter_chain()
     * @param string $text to be processed by the text
     * @param array $options filter options
     * @return string text after processing
     */
    public function filter($text, array $options = array()) {
        global $CFG, $easychem_configured;

        $search = "(\\%(.*?)\\%)is";
        $newtext = preg_replace_callback($search, array($this, 'callback'), $text);
/*
        if (($newtext != $text) && !isset($easychem_configured)) {
        $easychem_configured = true;

        $script = '<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
                   <script src="'.$CFG->wwwroot.'/filter/easychem/js/easychem.js" type="text/javascript"></script>
                   ';
        
        //$text = $script.$newtext;
        $text = $newtext;

        }
*/
       //$script = '';

       //$script = '<script src="http://localhost/moodle27/filter/easychem/js/easychem.js" type="text/javascript"></script>';
       $script = '<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>';
      // $script .= '<link rel="stylesheet" type="text/css" href="http://easychem.org/download/easychem.css" />';
        return $script.$newtext;
    }
    
    private function callback(array $matches) {
        global $PAGE;
        
        $embed = '<span class="easyChemConfig auto-compile"></span><div class="echem-formula" align="center">'.$matches[1].'</div>';
        //$embed =$div; 
        return $embed;
    }
}
