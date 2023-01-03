<script lang="ts">
	import {_} from 'svelte-i18n';
	import {PUBLIC_CAPTCHA, PUBLIC_CAPTCHA_SITEKEY, PUBLIC_CONTACT_ENDPOINT} from '$env/static/public';
	import message from "$lib/message";
	import {ToastType} from "$lib/Toast";
	import {onMount} from "svelte";

	let useCaptcha = PUBLIC_CAPTCHA === '1';
	let contactForm;
	let captchaWidgetId;

	async function submitForm(e: FormDataEvent) {
		e.preventDefault();
		e.stopPropagation();
		const formData = new FormData(contactForm);

		const contactBody = new URLSearchParams();

		contactBody.set('email', formData.get('email') as string);
		contactBody.set('subject', formData.get('subject') as string);
		contactBody.set('content', formData.get('content') as string);

		if (useCaptcha) {
			let res = hcaptcha.getResponse(captchaWidgetId);
			contactBody.set('h-captcha-response', res);
		}

		let res = await fetch(PUBLIC_CONTACT_ENDPOINT, {
			method: 'POST',
			body: contactBody,
		});

		let status = res.status;

		if (status !== 200) {
			let errorMessage = $_('contact.error');
			let data = await res.json();
			data.errors.forEach((error) => {
				const msg = error.message;
				errorMessage += "\n"+msg;
			});
			Object.keys(data.children).forEach((key) => {
				let child = data.children[key];
				child.errors.forEach((error) => {
					const msg = error.message;
					errorMessage += "\n"+key+': '+msg;
				});
			});
			message(errorMessage, ToastType.error);
			return;
		}

		contactForm.reset();
		if (useCaptcha) {
			hcaptcha.reset(captchaWidgetId);
		}

		message($_('contact.success'), ToastType.success);
	}

	onMount(function () {
		if (useCaptcha) {
			captchaWidgetId = hcaptcha.render('captcha', {
				sitekey: PUBLIC_CAPTCHA_SITEKEY,
			});
		}
	});
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
</style>

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

		<form action="#" bind:this={contactForm} on:submit|preventDefault={submitForm}>
			<div class="mb-3">
				<label for="email" class="form-label">Email address</label>
				<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
				<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
			</div>
			<div class="mb-3">
				<label for="subject" class="form-label">Subject of your message</label>
				<input type="text" class="form-control" id="subject" name="subject">
			</div>
			<div class="mb-3">
				<label for="content" class="form-label">Your message</label>
				<textarea class="form-control" id="content" name="content"></textarea>
			</div>
			{#if useCaptcha || true}
				<div id="captcha"></div>
				<script src="/js/hcaptcha.js"></script>
			{/if}
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</section>
