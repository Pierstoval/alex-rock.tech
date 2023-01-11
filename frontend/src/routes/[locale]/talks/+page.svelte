<script>
	import {_, date, locale} from 'svelte-i18n';
	import talks from '$lib/talks';
</script>

<section id="talks">
	<div class="container text-center">
		<h2>
			{$_('services.talks.title')}
		</h2>

		<blockquote>{$_('talks.stars_disclaimer')}</blockquote>

		<table>
			<thead>
				<tr>
					<th>{$_('language')}</th>
					<th>{$_('title')}</th>
					<th>{$_('event')}</th>
					<th>{$_('date')}</th>
					<th class="links">{$_('links')}</th>
				</tr>
			</thead>
			{#each talks as talk}
				<tr>
					<td class="text-center">{talk.lang}</td>
					<td class="text-left">{$_(talk.title)}</td>
					<td>{talk.conference}</td>
					<td>{$date(new Date(talk.date), {format: 'medium', locale: $locale})}</td>
					<td class="text-right">
						{#each talk.videos as url, i}
							<a href="{url}" class="btn sm red">
								<i class="fab fa-youtube"></i>
								{$_('talks.video')}
								{#if talk.videos.length > 1}{i}{/if}
							</a>
						{/each}
						{#each talk.slides as url, i}
							<a href="{url}" class="btn sm blue">
								<i class="fa fa-file-code"></i>
								{$_('talks.slides')}
								{#if talk.slides.length > 1}{i}{/if}
							</a>
						{/each}
					</td>
				</tr>
			{/each}
		</table>
	</div>
</section>

<style lang="scss">
	a.btn.sm {
		@apply m-0.5;
	}
	table {
		@apply w-full mx-auto max-w-5xl mb-5;
		td, th{
			@apply border-gray-200 border-2 px-1 py-1;
			&.links {
				@apply w-40;
			}
		}
	}
</style>
