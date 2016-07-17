/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			blacknews
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */

function bn_split( val ) {
	return val.split( /,\s*/ );
}
function bn_extractLast( term ) {
	return bn_split( term ).pop();
}

$(document).ready(function()
{
	if (typeof bNIDs !== 'undefined' && typeof bNLoaded === 'undefined')
	{
		// This is a workaround if backend.js is loaded twice
		bNLoaded	= true;


		$.datepicker.setDefaults( $.datepicker.regional[ DEFAULT_LANGUAGE.toLowerCase() ] );

		dialog_form(
			$('.bN_form'),
			false,
			function( data, textStatus, jqXHR )
			{
				var current			= $(this);
				current.find('input:file').val('');
				current.find('.info_last_update').text( data.time );
				current.find('input[name=url]').val( data.pageurl );
				current.closest('.bN_all')
					.find('input[name=news_id_' + data.news_id + ']').next('span').text( data.title );
				if ( data.image_url )
					$('.bN_show_image').html('<img src="' + data.image_url + '" alt="Preview" />');
			},
			'JSON',
			function( $form, options )
			{
				var	section_id		= $form.find('input[name=section_id]').val(),
					bN_long	='bN_long_' + section_id,
					bN_short	='bN_short_' + section_id;
		
				CKEDITOR.instances[bN_long].updateElement(),
				CKEDITOR.instances[bN_short].updateElement();
			}
		);

		dialog_form(
			$('.bN_form_options'),
			false,
			false,
			'JSON'
		);

		$.each( bNIDs, function( index, bNID )
		{
			
			var	$bN		= $('#bN_' + bNID.section_id),
				$bNForm	= $('#bN_form_' + bNID.section_id),
				$bNopt	= $bN.find('.bN_options'),
				$bNoptB	= $bN.find('.bN_options_button'),
				$bNcOpt	= $('#bN_cOpt_' + bNID.section_id);

			$('.show_more_options').click( function(e)
			{
				e.preventDefault();				
				$bNcOpt.slideToggle(200);
			}).click();

			$bN.on(
				'click',
				'.bN_close, .bN_options_button', function(e)
			{
				e.preventDefault();
				if ( $bNoptB.hasClass('active') )
				{
					$bNForm.slideUp(300, function() {
						$bNForm.removeClass('active')
					});
					$bNoptB.removeClass('active');
				}
				else {
					$bNForm.addClass('active').slideDown(300);
					$bNoptB.addClass('active');
				}
			});
			$bNopt.slideUp(0);

			$( '#bn_category_' + bNID.section_id )
			// don't navigate away from the field on tab when selecting an item
			.bind( 'keydown', function( event )
			{
				if ( event.keyCode === $.ui.keyCode.TAB &&
				$( this ).data( "ui-autocomplete" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
				bNID.allCategories, bn_extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = bn_split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});

console.log(DATE_FORMAT,TIME_FORMAT);

			var $pdt	= $( '#bN_dateEnd_' + bNID.section_id ),
				$pdf	= $( '#bN_dateStart_' + bNID.section_id ),
				formVal = {
					H:"HH",
					M:"mm",
					S:"ss"
			};
			$pdf.datetimepicker(
			{
				defaultDate:	'+1w',
				dateFormat:		DATE_FORMAT,
				timeFormat:		TIME_FORMAT.replace(/H|M|S/gi,function(matched){return formVal[matched];}),
				firstDay:		1,
				showSecond:		false,
				showMillisec:	false,
				showMicrosec:	false,
				showTimezone:	false,
				changeMonth:	true,
				oneLine:		true,
				controlType:	'select',
				numberOfMonths:	2,
				onClose: function( selectedDate )
				{
					$pdt.datetimepicker( "option", "minDate", selectedDate );
				}
			});
			$pdt.datetimepicker(
			{
				defaultDate:	'+1w',
				dateFormat:		DATE_FORMAT,
				timeFormat:		TIME_FORMAT.replace(/H|M|S/gi,function(matched){return formVal[matched];}),
				firstDay:		1,
				showSecond:		false,
				showMillisec:	false,
				showMicrosec:	false,
				showTimezone:	false,
				changeMonth:	true,
				oneLine:		true,
				controlType:	'select',
				numberOfMonths:	2,
				onClose: function( selectedDate )
				{
					$pdf.datetimepicker( "option", "maxDate", selectedDate );
				}
			});


			var $short_on	= $('#bN_shortbutton_' + bNID.section_id ),
				$s_on		= $('#bN_short_on_' + bNID.section_id ),
				$s_off		= $('#bN_short_off_' + bNID.section_id );
			if ( $short_on.prop('checked') ){
				$s_on.slideDown(0);
				$s_off.slideUp(0);
			} else {
				$s_on.slideUp(0);
				$s_off.slideDown(0);
			}

			$short_on.change( function(e)
			{
				e.preventDefault();
				if ( $short_on.prop('checked') ){
					$s_on.slideDown(200);
					$s_off.slideUp(200);
				} else {
					$s_on.slideUp(200);
					$s_off.slideDown(200);
				}
			});



			$('#bN_add_' + bNID.section_id ).click( function(e)
			{
				e.preventDefault();
				var current	= $('#bNcontent_' + bNID.section_id),
					url		= CAT_URL + '/modules/blacknews/save.php',
					dates		= {
						'page_id':		bNID.page_id,
						'section_id':	bNID.section_id,
						'action':		'addEntry',
						'_cat_ajax':	1
					};
				$.ajax(
				{
					type:		'POST',
					context:	current,
					url:		url,
					dataType:	'JSON',
					data:		dates,
					cache:		false,
					beforeSend:	function( data )
					{
						data.process	= set_activity( 'Adding new entry' );
					},
					success:	function( data, textStatus, jqXHR	)
					{
						var current			= $(this),
							current_ul		= $( '#bN_entries_' + bNID.section_id);
						if ( data.success === true )
						{
							current_ul.children('li').not(current).removeClass('active');
							current_ul.prepend('<li class="bn_icon-feed active drafted" id="bN_' + bNID.section_id +'_' + data.values.news_id + '"><input type="hidden" name="news_id_' + data.values.news_id + '" value="' + data.values.news_id + '" /> <span>' + data.values.title + '</span></li>');
				
							var	bN_long ='bN_long_' + data.section_id,
								bN_short ='bN_short_' + data.section_id;

							current.find('input[name=news_id]').val( data.values.news_id );
							current.find('input[name=title]').val( data.values.title );
							current.find('input[name=subtitle]').val( data.values.subtitle );
							current.find('input[name=url]').val( data.values.url );
							current.find('input[name=category]').val( data.values.categories );
							current.find('input[name=start]').val( data.values.start );
							current.find('input[name=end]').val( data.values.end );
							current.find('.info_created_by').text( data.values.user );
							current.find('.info_published').text( data.values.time );
							current.find('.info_last_update').text( data.values.time );
							current.find('.bN_short_check').prop( 'checked', data.values.auto_generate ).change();
							current.find('input[name=auto_generate_size]').val( data.values.auto_generate_size );
				
							CKEDITOR.instances[bN_long].setData( data.values.content );
							CKEDITOR.instances[bN_short].setData( data.values.short );
				
							if( data.values.active ){
								current.find('button.bn_icon-feed').removeClass('drafted').addClass('published');
							}
							else {
								current.find('button.bn_icon-feed').removeClass('published').addClass('drafted');
							}

							$( '#bN_entries_' + bNID.section_id ).sortable( "refresh" );

							return_success( jqXHR.process , data.message);
						}
						else {
							return_error( jqXHR.process , data.message);
						}
					}
				});
			});

			$( '#bN_entries_' + bNID.section_id ).on(
				'click',
				'li', function(e)
			{
				e.preventDefault();
				var current			= $(this),
					current_form	= $bNForm,
					url		= CAT_URL + '/modules/blacknews/save.php',
					dates		= {
						'news_id':		current.children('input').val(),
						'page_id':		bNID.page_id,
						'section_id':	bNID.section_id,
						'action':		'getInfo',
						'_cat_ajax':	1
					};
				$.ajax(
				{
					type:		'POST',
					context:	current,
					url:		url,
					dataType:	'JSON',
					data:		dates,
					cache:		false,
					beforeSend:	function( data )
					{
						data.process	= set_activity( 'Loading entry' );
					},
					success:	function( data, textStatus, jqXHR	)
					{
						var current_li		= $(this),
							current			= $( '#bNcontent_' + bNID.section_id),
							current_ul		= $( '#bN_entries_' + bNID.section_id);
			
						current_ul.children('li').removeClass('active').filter( current_li ).addClass('active');
			
						if ( data.success === true )
						{
							return_success( jqXHR.process , data.message);

							var	bN_long ='bN_long_' +	data.section_id,
								bN_short ='bN_short_' +	data.section_id,
								editor1	= CKEDITOR.instances[bN_long],
								editor2	= CKEDITOR.instances[bN_short];
							current.find('input[name=news_id]').val( data.values.news_id );
							current.find('input[name=title]').val( data.values.title );
							current.find('input[name=subtitle]').val( data.values.subtitle );
							current.find('input[name=url]').val( data.values.pageurl );
							current.find('input[name=category]').val( data.values.categories );
							current.find('input[name=start]').val( data.values.start );
							current.find('input[name=end]').val( data.values.end );
							current.find('.info_created_by').text( data.values.created_by );
							current.find('.info_published').text( data.values.created );
							current.find('.info_last_update').text( data.values.updated );
							current.find('.bN_short_check').prop( 'checked', data.values.auto_generate ).change();
							current.find('input[name=auto_generate_size]').val( data.values.auto_generate_size );
							if ( data.values.image_url )
								$('.bN_show_image').html('<img src="' + data.values.image_url + '" alt="Preview" />');
							else $('.bN_show_image').html('<span class="small">' + cattranslate('There was no picture added.','','','blacknews') + '</span>');
			
			
							editor1.setData( data.values.content );
							editor2.setData( data.values.short );
			
							if( data.values.active ){
								current.find('button.bn_icon-feed').removeClass('drafted').addClass('published');
							}
							else {
								current.find('button.bn_icon-feed').removeClass('published').addClass('drafted');
							}
						}
						else {
							return_error( jqXHR.process , data.message);
						}
					}
				});
			}).find('li:first').click();

			if ( $( '#bN_entries_' + bNID.section_id).children('li').size() == 0 )
			{
				$('#bN_add_' + bNID.section_id ).click();
			}



			$('#bNpublish_' + bNID.section_id).click( function(e)
			{
				e.preventDefault();
			
				var current		= $(this),
					form		= $( '#bNcontent_' + bNID.section_id),
					news_id		= form.find('input[name=news_id]').val(),
					url			= CAT_URL + '/modules/blacknews/save.php',
					dates		= {
						'section_id':			bNID.section_id,
						'page_id':				bNID.page_id,
						'news_id':				news_id,
						'action':				'publish',
						'publish':				current.hasClass('published') ? 0 : 1,
						'_cat_ajax':			1
					};
				$.ajax(
				{
					type:		'POST',
					context:	form,
					url:		url,
					dataType:	'JSON',
					data:		dates,
					cache:		false,
					beforeSend:	function( data )
					{
						data.process	= set_activity( 'Publishing entry' );
					},
					success:	function( data, textStatus, jqXHR	)
					{
						var current			= $(this).submit(),
							cur_parent		= current.closest('.bN_container');
						if ( data.success === true )
						{
							if ( data.active ) {
								current.find('button.bn_icon-feed').removeClass('drafted').addClass('published');
								cur_parent.find('input[value=' + data.news_id + ']').closest('.bn_icon-feed')
									.removeClass('drafted').addClass('published');
							}
							else {
								current.find('button.bn_icon-feed').removeClass('published').addClass('drafted');
								cur_parent.find('input[value=' + data.news_id + ']').closest('.bn_icon-feed')
									.removeClass('published').addClass('drafted');
							}
							return_success( jqXHR.process , data.message);
						}
						else {
							return_error( jqXHR.process , data.message);
						}
					}
				});
			});

			$('#bN_del_' + bNID.section_id ).click( function(e)
			{
				e.preventDefault();
			
				var current		= $( '#bNcontent_' + bNID.section_id),
					dates		= {
						'section_id':			bNID.section_id,
						'page_id':				bNID.page_id,
						'action':				'deleteEntry',
						'news_id':				current.find('input[name=news_id]').val(),
						'_cat_ajax':			1
					};
				dialog_confirm( 
					cattranslate( 'Do you really want to delete this entry?','','','blacknews' ),
					cattranslate( 'Deleting entry','','','blacknews' ),
					CAT_URL + '/modules/blacknews/save.php',
					dates,
					'POST',
					'JSON',
					false,
					function( data, textStatus, jqXHR )
					{
						var current			= $(this);
						var current_li		= current.find('input[value=' + data.news_id + ']').closest('.bn_icon-feed');
						if( current_li.index() > 0 ){
							current_li.prev('li').click();
						}
						else {
							current_li.next('li').click();
						};
						current_li.remove();
					},
					current.closest('.bN_container')
				);
			});

			$bN.find('.cc_toggle_set').next('form').hide();
			$bN.find('.cc_toggle_set, .bN_skin input:reset').unbind().click(function()
			{
				$(this).closest('.bN_skin').children('form').slideToggle(200);
			});

			$( '#bN_entries_' + bNID.section_id ).sortable(
			{
				axis:			'y',
				update:			function(event, ui)
				{
					var current			= $(this),
						form			= current.closest('.bN_container').find('form'),
						dates			= {
						'positions':		current.sortable('toArray'),
						'section_id':		bNID.section_id,
						'page_id':			bNID.page_id,
						'action':			'reorder',
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
							data.process	= set_activity( 'Sort entries' );
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