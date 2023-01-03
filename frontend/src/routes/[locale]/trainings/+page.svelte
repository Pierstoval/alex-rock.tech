<script>
	import {_} from 'svelte-i18n';
	import {marked} from "marked";
	import Training from '$lib/components/Training.svelte';

	const trainings = [
		{
			title : "training_item.php_discover",
			duration : 5,
			description : 'training_item.php_discover_text',
			selected: false,
		},
		{
			title : "training_item.php_oop",
			duration : 5,
			description : 'training_item.php_oop_text',
			selected: false,
		},
		{
			title : "training_item.symfony_discover",
			duration : 5,
			description : 'training_item.symfony_discover_text',
			selected: false,
		},
		{
			title : "training_item.symfony_advanced",
			duration : 5,
			description : 'training_item.symfony_advanced_text',
			selected: false,
		},
	];

	function chunks(array, size) {
		return Array.apply(0,{length: Math.ceil(array.length / size)}).map((_, index) => array.slice(index*size, (index+1)*size))
	}

	const chunked_array = chunks(trainings, 2);
</script>

<section class="page-section" id="trainings">
	<div class="container">

		<h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">
			{$_('services.training.title')}
		</h2>

		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon">
				<i class="fas fa-moon"></i>
			</div>
			<div class="divider-custom-line"></div>
		</div>

		<p>
			{@html marked($_('services.training.description'))}
		</p>

		<h2>{$_('services.training.courses')}</h2>

		{#each chunked_array as _trainings}
			<div class="card-deck">
				{#each _trainings as training}
					<Training
						title="{training.title}"
						duration={training.duration}
						description={training.description}
					/>
				{/each}
			</div>
		{/each}

		<p class="alert alert-info">{$_('services.trainings.more_and_custom')}</p>

	</div>
</section>
