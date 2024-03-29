<script lang="ts">
    import {_} from 'svelte-i18n';
    import {PUBLIC_CAPTCHA, PUBLIC_CAPTCHA_SITEKEY, PUBLIC_BACKEND_URL, PUBLIC_CONTACT_ENDPOINT} from '$env/static/public';
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

        let res = await fetch(PUBLIC_BACKEND_URL+PUBLIC_CONTACT_ENDPOINT, {
            method: 'POST',
            body: contactBody,
        });

        let status = res.status;

        if (status !== 200) {
            let errorMessage = $_('contact.error');
            let data = await res.json();
            data.errors.forEach((error) => {
                const msg = error.message;
                errorMessage += "\n" + msg;
            });
            Object.keys(data.children).forEach((key) => {
                let child = data.children[key];
                child.errors.forEach((error) => {
                    const msg = error.message;
                    errorMessage += "\n" + key + ': ' + msg;
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

<section>
    <div class="container">
        <h2 class="text-center uppercase">
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
            <a href="https://links.piers.tech/pierstoval">
                <i class="fa fa-link"></i>
            </a>
        </div>

        <form action="#" bind:this={contactForm} on:submit|preventDefault={submitForm}>
            <div class="mb-3">
                <label for="email">{$_('contact.form.email')}</label>
                <input type="email" id="email" name="email" aria-describedby="emailHelp">
                <div id="emailHelp">{$_('contact.form.data_usage_disclaimer')}</div>
            </div>
            <div class="mb-3">
                <label for="subject">{$_('contact.form.subject')}</label>
                <input type="text" id="subject" name="subject">
            </div>
            <div class="mb-3">
                <label for="content">{$_('contact.form.message')}</label>
                <textarea id="content" name="content"></textarea>
            </div>
            {#if useCaptcha || true}
                <div id="captcha"></div>
                <script src="/js/hcaptcha.js"></script>
            {/if}
            <button type="submit" class="btn">{$_('contact.form.send')}</button>
        </form>
    </div>
</section>

<style lang="scss">
    .contact-list {
        @apply text-center;
        a {
            @apply p-10 mx-8 mb-8 inline-block rounded-xl bg-gray-200 hover:bg-gray-300 text-emerald-400 text-5xl hover:text-emerald-500;
        }
    }
    form {
        input, select, textarea {
            @apply rounded-lg w-full border-gray-200 border-2 ring-emerald-200 ring-offset-0 focus:ring-2 focus:ring-emerald-200;
        }
        #emailHelp {
            @apply text-gray-400 text-sm;
        }
        label {
            @apply block;
        }
    }
</style>
