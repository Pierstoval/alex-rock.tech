<script>
	import Nav from '../components/Nav.svelte';

	export let segment;
</script>

<style type="text/scss">
	:global {
		@import 'assets/scss/app.scss';
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
