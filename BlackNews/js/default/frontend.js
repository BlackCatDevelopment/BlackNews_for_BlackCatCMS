/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			cc_form
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */



$(document).ready(function()
{
	var	$submit				= $( '#submitForm' );
	$('#ikFirstName').focus();

	$('#ikGender1, #ikGender2').click(function()
	{
		var	$check	= $('#ikGender1, #ikGender2'),
			$this	= $(this),
			$other	= $('#ikGender1, #ikGender2').not($this);
		$other.prop('checked',$other.prop('checked') ? false : true);
	});
	$('#ikVPGender1, #ikVPGender2').click(function()
	{
		var	$check	= $('#ikVPGender1, #ikVPGender2'),
			$this	= $(this),
			$other	= $('#ikVPGender1, #ikVPGender2').not($this);
		$other.prop('checked',$other.prop('checked') ? false : true);
	});

});