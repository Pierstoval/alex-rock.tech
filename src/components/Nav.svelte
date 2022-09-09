<script lang="ts">
    import { _, locale } from 'svelte-i18n';
    import NavLink from './NavLink.svelte';
    import { page } from '$app/stores';
    import type {Page} from "@sveltejs/kit";

    let nextLocale = 'en';
    let currentUrl = '';
    let nextLocaleUrl = '/';

    page.subscribe((page: Page) => {
        currentUrl = page.url.pathname;
    });
    locale.subscribe((newLocale: string) => {
        nextLocale = newLocale === 'en' ? 'fr' : 'en';
    });

    $: nextLocaleUrl = currentUrl.replace(/^\/(fr|en)?(.*)$/i, `/${nextLocale}$2`);
</script>

<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top navbar-shrink" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../../..">
            Alex-Rock.tech
        </a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="{$_('toggle_navigation')}">
            <span class="sr-only">Menu</span>
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="services" anchor="services.title">
                        This is my HTML!
                    </NavLink>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="trainings" anchor="services.training.title" />
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="coaching" anchor="services.coaching.title" />
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="talks" anchor="services.talks.title" />
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="contact" anchor="contact.title" />
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-lg-3" href="https://www.orbitale.io/">{$_('menu.blog')}</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a href="{nextLocaleUrl}" class="nav-link py-3 px-lg-3 text-info">
                        {nextLocale}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style lang="scss">
    #mainNav {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        .navbar-brand {
            font-size: 1.5em;
        }
    }
</style>
