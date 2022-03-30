{*
 *
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
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
 *
*}

<section id="bN_Entry">
    <figure>
        <div><div style="background-image:url({$entry.image});"></div></div>
        <figcaption class="c_1024">
            <h1>{$entry.title}</h1>
            <small>{assign var=class value=$entry.category.0.url}
                <a href="{cat_url}/{$options.permalink}/{$entry.category.0.url}" class="{$catIcons.$class}" title="{$entry.category.0.category}">{$entry.category.0.category}</a>
                <span class="icon-calendar">{format_date(strtotime($entry.publishDate))}</span>
            </small>
            <img src="{$entry.image}" alt="{$entry.title}">
        </figcaption>
    </figure>
    <article class="c_1024">
            {$entry.content}
        <p><br><a class="button {if $referer>0}{$catIcons.$class}{else}icon-arrow-left{/if}" href="{if $referer>0}{cat_url}/{$options.permalink}/{$entry.category.0.url}{elseif $referer<0}{cmsplink(-$referer)}{else}{cat_url}/{$options.permalink}{/if}"> Zur&uuml;ck zu{if $referer>0} {$entry.category.0.category}{elseif $referer<0} {menutitle(-$referer)}{else}r &Uuml;bersicht{/if}</a></p>
        {$gallery}
    </article>
</section>