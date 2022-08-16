<script lang="ts">
	import { Page } from "@sveltejs/kit";
	import { page } from '$app/stores';
	import {init, locale} from 'svelte-i18n';
	import '../i18n';
	import Nav from '../components/Nav.svelte';

	page.subscribe((page: Page) => {
		let url: URL = page.url;
		let lang = url.href.replace(/^\/([^\/]+(\/|$))?/g, '$2');

		console.info({url, lang});

		locale.set(lang);
		init({
			fallbackLocale: lang,
			initialLocale: lang,
		});
	});

    /** @type {import('./$types').PageData */
    export let data;
    $: ({ segment } = data);

	export let segment;
</script>

<style>
	:global {
		@import '../../../assets/scss/app';
	}
</style>

<span id="page-top" data-segment="{segment}"></span>

<Nav />

<div id="content">
	<slot></slot>
</div>

<div class="scroll-to-top d-lg-none position-fixed">
	<a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top">
		<i class="fa fa-chevron-up"></i>
	</a>
</div>
