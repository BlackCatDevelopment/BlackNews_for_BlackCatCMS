/**
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright			2016, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blacknews
 *
 */


$(document).ready(function()
{
	$('.bN_eq .bN_row').each( function()
	{
		var height			= 0,
			current_row		= $(this);
		current_row.children('.bN').each( function()
		{
			var current_height		= $(this).find('.bN_content').outerHeight();
			height					= height < current_height ? current_height : height;
		});
		current_row.find('.bN_content').css({height: height});
	});
});