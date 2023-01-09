<script lang="ts">
	import "@fontsource/montserrat";
	import "@fontsource/montserrat/700.css";
	import "@fontsource/lato";
	import "@fontsource/lato/700.css";

	import { type Page } from "@sveltejs/kit";
	import { page } from '$app/stores';
	import {init, locale} from 'svelte-i18n';
	import '$lib/i18n';
	import Nav from '$lib/components/Nav.svelte';
	import Footer from "$lib/components/Footer.svelte";
	import {SvelteToast} from '@zerodevx/svelte-toast';

	let currentLocale = 'en';

	locale.subscribe((loc: string) => currentLocale = loc);

	page.subscribe((page: Page) => {
		let lang = page.params.locale;

		if (!lang) {
			lang = 'en';
		}

		if (lang !== 'fr' && lang !== 'en') {
			throw new Error(`Invalid locale ${lang}`);
		}

		locale.set(lang);

		init({
			fallbackLocale: lang,
			initialLocale: lang,
		});
	});
</script>

<span id="page-top" data-segment="{$locale}"></span>

<div id="toast_container">
	<SvelteToast />
</div>

<Nav />

<div id="content">
	<slot></slot>
</div>

<Footer />

<div class="scroll-to-top d-lg-none position-fixed">
	<a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
		<i class="fa fa-chevron-up"></i>
	</a>
</div>

<style lang="scss" global>
	@import '../styles/app.scss';
	#toast_container {
		--toastContainerTop: auto;
		--toastContainerRight: 1rem;
		--toastContainerBottom: 0.5rem;
		--toastContainerLeft: auto;
	}
</style>
