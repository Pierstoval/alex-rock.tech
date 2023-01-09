<script>
	import {_, locale} from 'svelte-i18n';
	import {marked} from "marked";
	import LilMoonHeading from "$lib/components/LilMoonHeading.svelte";
</script>

<section id="services">
	<div class="container">
		<div>
			<h2>
				{$_('services.development.title')}
			</h2>

			<LilMoonHeading dark={true} />

			<div>
				{@html marked($_('services.development.description').replace("\n", '<br>'))}
				<br>
				{@html marked($_('services.development.side_note').replace("\n", '<br>'))}
			</div>

			<a href="/{$locale}/contact" id="contact_link">
				{$_('service_item_button')}
			</a>
		</div>
	</div>
</section>

<style lang="scss">
	h2 {
		@apply text-center;
	}
	:global li {
		@apply list-disc ml-8;
	}
	:global strong {
		@apply text-gray-800;
	}
	#contact_link {
		@apply btn;
		@apply inline-block rounded-lg px-4 py-2;
	}
</style>
