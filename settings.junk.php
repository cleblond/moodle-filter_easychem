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
 * MathJAX filter settings
 *
 * @package    filter_easychem
 * @copyright  2014 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $item = new admin_setting_heading('filter_easychem/localinstall',
                                      new lang_string('localinstall', 'filter_easychem'),
                                      new lang_string('localinstall_help', 'filter_easychem'));
    $settings->add($item);

    $item = new admin_setting_configtext('filter_easychem/httpurl',
                                         new lang_string('httpurl', 'filter_easychem'),
                                         new lang_string('httpurl_help', 'filter_easychem'),
                                         'http://cdn.mathjax.org/mathjax/2.3-latest/MathJax.js',
                                         PARAM_RAW);
    $settings->add($item);

    $item = new admin_setting_configtext('filter_easychem/httpsurl',
                                         new lang_string('httpsurl', 'filter_easychem'),
                                         new lang_string('httpsurl_help', 'filter_easychem'),
                                         'https://cdn.mathjax.org/mathjax/2.3-latest/MathJax.js',
                                         PARAM_RAW);
    $settings->add($item);

    $item = new admin_setting_configcheckbox('filter_easychem/texfiltercompatibility',
                                             new lang_string('texfiltercompatibility', 'filter_easychem'),
                                             new lang_string('texfiltercompatibility_help', 'filter_easychem'),
                                             0);
    $settings->add($item);

    $default = '
MathJax.Hub.Config({
    config: ["MMLorHTML.js", "Safe.js"],
    jax: ["input/TeX","input/MathML","output/HTML-CSS","output/NativeMML"],
    extensions: ["tex2jax.js","mml2jax.js","MathMenu.js","MathZoom.js"],
    TeX: {
        extensions: ["AMSmath.js","AMSsymbols.js","noErrors.js","noUndefined.js"]
    },
    menuSettings: {
        zoom: "Double-Click",
        mpContext: true,
        mpMouse: true
    },
    errorSettings: { message: ["!"] },
    skipStartupTypeset: true,
    messageStyle: "none"
});
';

    $item = new admin_setting_configtextarea('filter_easychem/mathjaxconfig',
                                             new lang_string('mathjaxsettings','filter_easychem'),
                                             new lang_string('mathjaxsettings_desc', 'filter_easychem'),
                                             $default);

    $settings->add($item);

    $item = new admin_setting_configtext('filter_easychem/additionaldelimiters',
                                         new lang_string('additionaldelimiters', 'filter_easychem'),
                                         new lang_string('additionaldelimiters_help', 'filter_easychem'),
                                         '',
                                         PARAM_RAW);
    $settings->add($item);

}
