<script>
	import {_, date} from 'svelte-i18n';
	import talks from '$lib/talks';
</script>

<section class="page-section portfolio" id="talks">
	<div class="container">
		<div class="justify-content-center">

			<h2 class="page-section-heading text-center text-secondary text-uppercase mb-4">
				{$_('services.talks.title')}
			</h2>

			<blockquote>{$_('talks.stars_disclaimer')}</blockquote>

			{#each talks as _talks}
				<div class="row mb-4">
					{#each _talks as talk}
						<div class="col-6">
							<div class="card">
								<div class="card-body">
									<h3 class="card-title">
										{$_(talk.title)}
									</h3>
									<p class="card-subtitle">
										<span class="badge badge-secondary">{$_('lang_with_colon')} {talk.lang}</span>
										&ndash;
										{talk.conference}
										&ndash;
										{$date(new Date(talk.date), 'full')}
									</p>
									<p class="card-text mt-1">
										{#each talk.videos as url, i}
											<a href="{url}" class="card-link pl-2 pr-2 btn btn-sm btn-primary">
												<i class="fa fa-video"></i>
												{$_('talks.video')}
												{#if talk.videos.length > 1}{i}{/if}
											</a>
										{/each}
										{#each talk.slides as url, i}
											<a href="{url}" class="card-link pl-2 pr-2 btn btn-sm btn-info">
												<i class="fa fa-file-code"></i>
												{$_('talks.slides')}
												{#if talk.slides.length > 1}{i}{/if}
											</a>
										{/each}
									</p>
								</div>
							</div>
						</div>
					{/each}
				</div>
			{/each}
		</div>
	</div>
</section>
