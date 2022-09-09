<script>
	import {_} from 'svelte-i18n';
	import { onMount } from 'svelte';
	let hbsptReady = false;
	let mounted = false;

	export let current_locale;

	onMount(() => {
		mounted = true;
		hbsptReady && loadhbsptElements();
	});

	function hbsptLoaded() {
		hbsptReady = true;
		mounted && loadhbsptElements();
	}

	function loadhbsptElements() {
		hbspt.forms.create({
			portalId: "7765504",
			target: '#hbspt-form',
			formId: current_locale === 'fr' ? "27d956a5-4966-44cf-8bf7-e460118381ad" : 'bdd1ecf9-0d91-422a-8d84-519739014340'
		});
	}
</script>

<style lang="scss">
  .fab, .fa {
    font-size: 3em;
  }
  .contact-list {
    text-align: center;
    margin-top: 50px;
    a {
      padding: 30px 30px;
      margin: 15px;
      display: inline-block;
      border-radius: 5px;
      background: #eee;
      &:hover {
        background: #ddd;
      }
    }
  }
  #hbspt-form {
    max-width: 80%;
    width: 80%;
    margin: 0 auto;
  }
</style>

<svelte:head>
	<script src="//js.hsforms.net/forms/shell.js" on:load={hbsptLoaded}></script>
</svelte:head>

<section class="page-section" id="contact">
	<div class="container">

		<h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">
			{$_('contact.me.title')}
		</h2>

		<div class="contact-list">
			<a href="https://twitter.com/pierstoval">
				<i class="fab fa-twitter"></i>
			</a>
			<a href="https://www.instagram.com/pierstoval">
				<i class="fab fa-instagram"></i>
			</a>
			<a href="https://www.linkedin.com/in/alex-rock/">
				<i class="fab fa-linkedin"></i>
			</a>
		</div>

		<div id="hbspt-form"></div>
	</div>
</section>
