{*
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
*}

<article class="bN_Entries">	
	{if $entry.image}<figure>
		<div style="background-image: url('{$entry.image}');">
			<img src="{$entry.image}" class="bN_mImage">
		</div>
		<figcaption>{/if}
		<h2>{$entry.title}</h2>
		{if $entry.short}{$entry.short}{else}<p>{truncateHTML($entry.text,100)}</p>{/if}
		<aside>
			<a href="{cat_url}/{$options.permalink}/{$entry.seoURL}/" class="icon-book"> <span>weiterlesen...</span></a>
			<span class="bNDate">{date('d.m.',$entry.publishUT)}</span>
			<span class="bNYear">{date('y',$entry.publishUT)}</span>
		</aside>
		{if $entry.image}</figcaption>
	</figure>{/if}
</article>