/**
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.   
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'  
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.  
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    | 
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'  
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
 *   @copyright			2018, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blackNews
 *
 */


$(document).ready(function()
{
	$.each( bcIDs, function( index, bcID )
	{
		$('.bc_addGallery').click(function(e)
		{
			e.preventDefault();
			var $cur		= $(this),
				$bcUL		= $('#blackNews_' + bcID.section_id),
				$save		= $bcUL.find('.bc_Save'),
				$WYSIWYG	= $('#wysiwyg_' + bcID.section_id),
				$Form		= $('#bc_Form_'  + bcID.section_id ),
				$sBar		= $('#blackNewsList_' + bcID.section_id),
				$footer		= $bcUL.find('.bc_Main').children('footer');

			$.ajax(
			{
				type:		'POST',
				context:	$bcUL,
				url:		CAT_URL + '/modules/blacknews/save/ics/save.php',
				dataType:	'JSON',
				data:		{
					action:		'addGallery',
					_cat_ajax:	1,
					page_id:	bcID.page_id,
					section_id:	bcID.section_id,
					entryID:	getEntryID( $Form ),
					values:		getValue($Form,$WYSIWYG.attr('id')),
					options:	getOptions($Form)
				},
				cache:		false,
				beforeSend:	function( data )
				{
					// Set activity and store in a variable to use it later
					data.process	= set_activity( 'Adding gallery' );
				},
				success:	function( data, textStatus, jqXHR )
				{
					if ( data.success === true )
					{
						window.location.replace(data.url);
//						return_success( jqXHR.process, data.message );
//						$sBar.find('[data-entryid="' + data.entryID + '"]').text( ' ' + data.values.title );
//						setInformation($footer,data.values.display_name,data.values.created,data.values.modified);
						
					} else {
						return_error( jqXHR.process , data.message );
					}
				},
				error:		function( jqXHR, textStatus, errorThrown )
				{
					console.log(jqXHR.responseText);
				}
			});
			return false;
		});
	});
});