<script lang="ts">
	import "@fontsource/montserrat";
	import "@fontsource/montserrat/700.css";
	import "@fontsource/lato";
	import "@fontsource/lato/700.css";

	import '$lib/i18n';
	import Nav from '$lib/components/Nav.svelte';
	import Footer from "$lib/components/Footer.svelte";
	import {SvelteToast} from '@zerodevx/svelte-toast';
	import {init} from "$lib/i18n";
	import {locale} from "svelte-i18n";

	let currentLocale = 'en';

	locale.subscribe((loc: string) => currentLocale = loc);

	init(currentLocale || 'en');
</script>

<span id="page-top"></span>

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
