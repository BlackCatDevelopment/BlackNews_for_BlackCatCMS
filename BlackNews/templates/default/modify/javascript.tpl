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

<script >
	if (typeof bcIDs === 'undefined')
	\{
		bcIDs	= [];
	}
	bcIDs.push(
	\{
		'page_id'		: {$page_id},
		'section_id'	: {$section_id},
		'bcID'			: {if $bcID}{$bcID}{else}1{/if}
	});

	// Tag-Autocomplete im Entry-Formular
	(function(){
		var sid = {$section_id};
		var typeSel = document.getElementById('bN_tagType_' + sid);
		var nameIn  = document.getElementById('bN_tagName_' + sid);
		var listEl  = document.getElementById('bN_tagList_' + sid);
		var addBtn  = document.getElementById('bN_tagAdd_' + sid);
		var input   = document.getElementById('bN_tagsInput_' + sid);
		var box     = document.getElementById('bN_tags_' + sid);
		if (!typeSel || !addBtn) return;

		var current = [];

		function refreshInput(){
			input.value = JSON.stringify(current);
			box.innerHTML = current.map(function(t, i){
				return '<span class="bN_tag">' + t.type + ': ' + t.name +
					' <a href="#" data-i="' + i + '" class="bN_tagDel">&times;</a></span>';
			}).join(' ');
			box.querySelectorAll('.bN_tagDel').forEach(function(a){
				a.addEventListener('click', function(e){
					e.preventDefault();
					current.splice(parseInt(a.getAttribute('data-i'), 10), 1);
					refreshInput();
				});
			});
		}

		function loadTypes(){
			var b = new URLSearchParams();
			b.append('action', 'getTags'); b.append('_cat_ajax', '1'); b.append('section_id', sid);
			fetch('{$CAT_URL}/modules/blackNews/save.php', {method:'POST', body:b.toString()})
				.then(function(r){ return r.json(); })
				.then(function(res){
					if (!res || !res.success) return;
					(res.types || []).forEach(function(t){
						var o = document.createElement('option'); o.value = t; o.textContent = t; typeSel.appendChild(o);
					});
				});
		}

		function loadSuggestions(){
			var b = new URLSearchParams();
			b.append('action', 'getTags'); b.append('_cat_ajax', '1'); b.append('section_id', sid);
			b.append('type', typeSel.value);
			fetch('{$CAT_URL}/modules/blackNews/save.php', {method:'POST', body:b.toString()})
				.then(function(r){ return r.json(); })
				.then(function(res){
					if (!res || !res.success) return;
					listEl.innerHTML = '';
					Object.keys(res.tags || {}).forEach(function(id){
						var t = res.tags[id];
						var o = document.createElement('option'); o.value = t.name; listEl.appendChild(o);
					});
				});
		}

		typeSel.addEventListener('change', loadSuggestions);
		addBtn.addEventListener('click', function(){
			var name = nameIn.value.trim();
			if (typeSel.value && name) {
				current.push({type: typeSel.value, name: name});
				nameIn.value = '';
				refreshInput();
			}
		});
		loadTypes();
	})();
</script>