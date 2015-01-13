YUI.add('moodle-filter_easychem-loader', function (Y, NAME) {

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
 * Mathjax JS Loader.
 *
 * @package    filter_easychem
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
M.filter_easychem = M.filter_easychem || {
    /**
     * Called by the filter when an equation is found while rendering the page.
     *
     * @method typeset
     */
    typeset: function() {
            Y.use('node', 'easychem', function() {
                Y.all('.echem-formula').each(function(node) {
                            var src = node.get('innerHTML');
                            // Take care of problem with | character and replace problem!
                            var str = src.split("|");
                            Y.log(str);
                            for(var i = 0; i < str.length; i++) {
                                str[i] = str[i].replace("&gt;", ">").replace("&lt;","<");
                            }
                            src = str.join("|");
                            var res = ChemSys.compile(src);
                            ChemSys.draw(node.empty(), res);
                });
            });
    }
};


}, '@VERSION@', {"requires": ["moodle-core-event"]});
