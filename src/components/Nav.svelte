<script>
    import { _, locale } from 'svelte-i18n';
    import NavLink from './NavLink.svelte';
    import { stores } from '@sapper/app';
    const { page } = stores();

    function changeLocale(e) {
        e.preventDefault();
        e.stopPropagation();
        locale.set(nextLocale);
        nextLocale = nextLocale === 'en' ? 'fr' : 'en';
    }

    let nextLocale = $locale === 'en' ? 'fr' : 'en';

    $: localeUrl = $page.path.replace(/^\/(fr|en)/i, nextLocale);
</script>

<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top navbar-shrink" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href=".">
            Alex-Rock.tech
        </a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="{$_('toggle_navigation')}">
            <span class="sr-only">Menu</span>
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <NavLink locale="{$locale}" page="services" anchor="services.title" />
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
                    <a href="{localeUrl}" class="nav-link py-3 px-lg-3 text-info" on:click={changeLocale}>
                        {nextLocale}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
