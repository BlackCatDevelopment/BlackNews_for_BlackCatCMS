/*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

   @author          Black Cat Development
   @copyright       2016 Black Cat Development
   @link            http://blackcat-cms.org
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Core
   @package         CAT_Core

*/


if (typeof bN_PU !== 'function')
{
	function bN_PU( state )
	{
		unloadMessage			= 'Es werden aktuell Bilder hochgeladen!';
		window.onbeforeunload	= state ? function() { return unloadMessage; } : null;
	}
}

function resetForm($Form)
{
	$.each($Form.find('[name=saveFields]').val().split('|'), function(key,val)
	{
		if ( val != '' )
		{
			var field	= val.split(',');
			switch(field[1])
			{
				case 'select':
					$Form.find('[name='+field[0]+']').prop("selectedIndex", 0);
					break;
				case 'checkbox':
				case 'radio':
					$Form.find('[name='+field[0]+']').prop('checked',false);
					break;
				case 'wysiwyg':
					var editorInstance	= CKEDITOR.instances[wID];
					editorInstance.setData('');
					editorInstance.updateElement();
					break;
				default:
					$Form.find('[name='+field[0]+']').val('');
					break;
			}
		}
	});
}

function setValue($el,wID,standard,options)
{
	$.each({'saveFields': standard, 'saveOptions': options}, function(type,values)
	{
		$.each($el.find('[name='+type+']').val().split('|'), function(key,val)
		{
			if ( val != '' )
			{
				var field	= val.split(',');
				switch(field[1])
				{
					case 'checkbox':
						$el.find('[name='+field[0]+']').prop('checked', values[field[0]] ? true : false);
						break;
					case 'radio':
						$el.find('input[name='+field[0]+']').filter('[value='+values[field[0]]+']').prop('checked', values[field[0]] ? true : false);
						break;
					case 'wysiwyg':
						var editorInstance	= CKEDITOR.instances[wID];
						editorInstance.setData( values.content ? values.content : '' );
						editorInstance.updateElement();
						break;
					default:
						$el.find('[name='+field[0]+']').val( values[field[0]] ? values[field[0]] : '' );
						break;
				}
			}
		});
	});
}

function getValue($Form,wID)
{
	var saveField	= {};
	$.each($Form.find('[name=saveFields]').val().split('|'), function(key,val)
	{
		if ( val != '' )
		{
			var field	= val.split(',');
			switch(field[1])
			{
				case 'select':
					saveField[field[0]]	= $Form.find('[name='+field[0]+'] option:selected').val();
					break;
				case 'checkbox':
					saveField[field[0]]	= $Form.find('[name='+field[0]+']').is(':checked');
					break;
				case 'radio':
					saveField[field[0]]	= $Form.find('input[name='+field[0]+']:checked').val();
					break;
				case 'wysiwyg':
					var editorInstance	= CKEDITOR.instances[wID];
					saveField[field[1]]	= editorInstance.getData();
					break;
				default:
					saveField[field[0]]	= $Form.find('[name='+field[0]+']').val();
					break;
			}
		}
		else return '';
	});
	return saveField;
}

function getOptions($Form)
{
	var saveField	= [];
	$.each($Form.find('[name=saveOptions]').val().split('|'), function(key,val)
	{
		if ( val != '' )
		{
			var field	= val.split(',');
			switch(field[1])
			{
				case 'select':
					saveField.push({
						'name':		field[0],
						'value':	$Form.find('[name='+field[0]+'] option:selected').val(),
						'type':		'select'
					});
					break;
				case 'checkbox':
					saveField.push({
						'name':		field[0],
						'value':	$Form.find('[name='+field[0]+']').is(':checked'),
						'type':		'select'
					});
					break;
				case 'radio':
					saveField.push({
						'name':		field[0],
						'value':	$Form.find('input[name='+field[0]+']:checked').val(),
						'type':		'radio'
					});
					break;
				default:
					saveField.push({
						'name':		field[0],
						'value':	$Form.find('[name='+field[0]+']').val(),
						'type':		'text'
					});
					break;
			}
		}
		else return '';
	});
	return saveField;
}


function getEntryID($el)
{
	return $el.data('entryid');
}

function setActive($el)
{
	$el.parent().children().removeClass('active');
	$el.addClass('active');
}

function getActive($el)
{
	return $el.children('.active');
}


$(document).ready(function()
{
	if (typeof bcIDs !== 'undefined' && typeof bcLoaded === 'undefined')
	{
		// This is a workaround if backend.js is loaded twice
		bcLoaded	= true;
		$.each( bcIDs, function( index, bcID )
		{
			var $bcUL		= $('#blackNews_' + bcID.section_id),
				$WYSIWYG	= $('#wysiwyg_' + bcID.section_id).hide(),
				$bcNav		= $('#bc_nav_' + bcID.section_id),
				$setKind	= $bcUL.find('.set_kind'),
				$add		= $bcUL.find('.bc_add'),
				$save		= $bcUL.find('.bc_Save'),
				$delete		= $bcUL.find('.bc_Delete'),
				$publish	= $bcUL.find('.bc_Publish'),
				$copy		= $bcUL.find('.bc_Copy'),
				$sBar		= $('#blackNewsList_' + bcID.section_id),
				$Form		= $('#bc_Form_'  + bcID.section_id ),
				$OptForm	= $('#bc_Options_' + bcID.section_id ),
				$OptButton	= $('#bn_gOpt_' + bcID.section_id ),
				$saveOpt	= $OptForm.find('#saveOption_' + bcID.section_id ),
				saveField	= getValue($Form,$WYSIWYG.attr('id')),
				$formular	= $('#bc_Formular_'+ bcID.section_id ),
				$table		= $formular.children('table').children('tbody'),
				$prevIMG	= $('#bN_previewIMG_' + bcID.section_id ),
				$IMGs		= $('#bN_imgs_' + bcID.section_id );


			$('#bN_dropzone_' + bcID.section_id).dropzone(
			{
				url:				CAT_URL + '/modules/blacknews/save.php',
				paramName:			'bNimage',
				uploadMultiple:		false,
				acceptedFiles:		'image/*',
				thumbnailWidth:		300,
				thumbnailHeight:	200,
				sending:			function(file, xhr, formData)
				{
					formData.append('page_id', bcID.page_id);
					formData.append('section_id', bcID.section_id);
					formData.append('entryID', getEntryID($Form));
					formData.append('action', 'uploadIMG');
					formData.append('_cat_ajax', 1);
					bN_PU( true );
				},
				drop:				function(file, xhr, formData)
				{
					$IMGs.html('');
				},
				previewsContainer:	'#bN_imgs_' + bcID.section_id,
				previewTemplate:	$IMGs.html(),
				success:			function(file, xhr, formData)
				{
					console.log(file, xhr, formData);
					console.log(file.xhr.response);
					$IMGs.find('.dz-progress').remove();
					// Unvollständigen Upload durch wechseln der Seite verhindern
					if( $IMGs.find('.dz-progress').size() == 0 ) bN_PU( false );

/*					var $newIMG	= $(file.previewElement),
						
						newID	= $newIMG.attr('id') + xhr.newIMG.image_id;

					$newIMG.find('.dz-progress').remove();
					$newIMG.find('.dz-filename span').text(xhr.newIMG.picture);
					$newIMG.find('input[name=imgID]').val(xhr.newIMG.image_id);
					$newIMG.find('.bN_image img').attr('src',xhr.newIMG.thumb);
					$newIMG.find('input, button, textarea').prop('disabled',false);
					$newIMG.find('.bN_disabled').removeClass('bN_disabled');*/

				}
			});

			$OptButton.click(function(e)
			{
				e.preventDefault();
				$OptForm.toggleClass('active');
			});

			$formular.on(
				'click',
				'button',
			function(e)
			{
				e.preventDefault();
				var $cur	= $(this),
					values	= getValue($cur.closest('tr'));
				if ( $cur.hasClass('bc_addField') )
				{
					var action	= 'addField',
						process	= 'Adding field';
				} else if ( $cur.hasClass('bc_deleteField') )
				{
					var action	= 'deleteField',
						process	= 'Deleting field';
				} else // bc_saveField
				{
					var action	= 'saveField',
						process	= 'Saving field';
				}
				$.ajax(
				{
					type:		'POST',
					context:	$bcUL,
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		action,
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($Form),
						fieldID:	values.fieldID,
						values:		values
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( process );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							if ( action == 'addField' )
							{
								resetForm($cur.closest('tr'));
								$table.children('tr').not('.bn_FormularInput').remove();
								$table.append( data.html );
								$table.sortable( 'refresh' );
							} else if ( action == 'deleteField' )
							{
								$cur.closest('tr').remove();
							}
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});

			$save.click( function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	$bcUL,
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'save',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($Form),
						values:		getValue($Form,$WYSIWYG.attr('id')),
						options:	getOptions($Form)
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Saving entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							$sBar.prepend( data.html );
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});

			$add.click(function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	$bcUL,
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'add',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Adding entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							$sBar.prepend( data.html );
							$sBar.sortable( 'refresh' );
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});

			$delete.click(function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	$sBar.children('#bc_Entry_' + getEntryID($Form)),
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'remove',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($Form)
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Deleting entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							var	$cur	= $(this),
								$next	= $cur.next().length ? $cur.next() : $cur.prev();
							$cur.remove();
							$next.click();
							$sBar.sortable( 'refresh' );
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});

			$publish.click(function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	getActive($sBar),
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'publish',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($Form)
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Set publish of entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							if ( data.publish == 1 ) $(this).add($publish).addClass('published');
							else $(this).add($publish).removeClass('published');
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});

			$copy.click( function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	$bcUL,
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'copy',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($Form)
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Saving entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						if ( data.success === true )
						{
							return_success( jqXHR.process, data.message );
							$sBar.prepend( data.html );
						} else {
							return_error( jqXHR.process , data.message );
						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});


			$sBar.on(
				'click',
				'li', function (e) {
				$.ajax(
				{
					type:		'POST',
					context:	$(this),
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'get',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						entryID:	getEntryID($(this))
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Load entry' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						console.log( data, textStatus, jqXHR);
						return_success( jqXHR.process, data.message );
						if ( data.success === true )
						{
							$prevIMG.attr('src',data.image ? data.image + '?' + Math.floor(Math.random() * 10000 ) : '' );
							$Form.data('entryid',getEntryID($(this)));

							setActive($(this));
							if ( data.publish == 1 ) $publish.addClass('published');
							else $publish.removeClass('published');
	
							setValue($Form,$WYSIWYG.attr('id'),data,data.options);

							$table.children('tr').not('.bn_FormularInput').remove();
							$table.append( data.html );

						}
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			}).children(':first').click();

			$bcUL.find('.cc_toggle_set').next('form').hide();
			$bcUL.find('.cc_toggle_set, .bc_skin input:reset').click(function()
			{
				$(this).closest('.bc_skin').children('form').slideToggle(200);
			});


			$saveOpt.click( function(e) {
				e.preventDefault();
				$.ajax(
				{
					type:		'POST',
					context:	$bcUL,
					url:		CAT_URL + '/modules/blacknews/save.php',
					dataType:	'JSON',
					data:		{
						action:		'saveOptions',
						_cat_ajax:	1,
						page_id:	bcID.page_id,
						section_id:	bcID.section_id,
						options:	getOptions($OptForm)
					},
					cache:		false,
					beforeSend:	function( data )
					{
						// Set activity and store in a variable to use it later
						data.process	= set_activity( 'Saving options' );
					},
					success:	function( data, textStatus, jqXHR )
					{
						$OptButton.click();
						return_success( jqXHR.process, data.message );
					},
					error:		function( jqXHR, textStatus, errorThrown )
					{
						console.log(jqXHR.responseText);
					}
				});
			});


			$sBar.sortable(
			{
				axis:			'y',
				update:			function(event, ui)
				{
					var $cur			= $(this),
						dates			= {
							'action':			'orderEntries',
							'section_id':		bcID.section_id,
							'page_id':			bcID.page_id,
							'positions':		$cur.sortable('toArray', {attribute: 'data-entryid'}),
							'_cat_ajax':		1
					};
					$.ajax(
					{
						type:		'POST',
						url:		CAT_URL + '/modules/blacknews/save.php',
						dataType:	'json',
						data:		dates,
						cache:		false,
						beforeSend:	function( data )
						{
							data.process	= set_activity( 'Sort fields' );
						},
						success:	function( data, textStatus, jqXHR	)
						{
							if ( data.success === true )
							{
								return_success( jqXHR.process, data.message );
							}
							else {
								return_error( jqXHR.process , data.message );
							}
						},
						error:		function(jqXHR, textStatus, errorThrown)
						{
							return_error( jqXHR.process , errorThrown.message);
						}
					});
				}
			});

			$table.sortable(
			{
				axis:			'y',
				items:			'tr:not(.bn_FormularInput)',
				handle:			'.bc_icon-FieldDD',
				update:			function(event, ui)
				{
					var $cur			= $(this),
						dates			= {
						'action':			'orderFields',
						'section_id':		bcID.section_id,
						'page_id':			bcID.page_id,
						'positions':		$cur.sortable('toArray', {attribute: 'data-fieldid'}),
						'_cat_ajax':		1
					};
					$.ajax(
					{
						type:		'POST',
						url:		CAT_URL + '/modules/blacknews/save.php',
						dataType:	'json',
						data:		dates,
						cache:		false,
						beforeSend:	function( data )
						{
							data.process	= set_activity( 'Sort fields' );
						},
						success:	function( data, textStatus, jqXHR	)
						{
							if ( data.success === true )
							{
								return_success( jqXHR.process, data.message );
							}
							else {
								return_error( jqXHR.process , data.message );
							}
						},
						error:		function(jqXHR, textStatus, errorThrown)
						{
							return_error( jqXHR.process , errorThrown.message);
						}
					});
				}
			});
		});
	}

});