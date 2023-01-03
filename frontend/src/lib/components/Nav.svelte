<script lang="ts">
    import { _, locale } from 'svelte-i18n';
    import { page } from '$app/stores';
    import type {Page} from "@sveltejs/kit";

    let nextLocaleEmoji = '🇬🇧';
    let nextLocale = 'en';
    let currentUrl = '';
    let nextLocaleUrl = '/';

    page.subscribe((page: Page) => {
        currentUrl = page.url.pathname;
    });
    locale.subscribe((newLocale: string) => {
        nextLocale = newLocale === 'en' ? 'fr' : 'en';
    });

    let collapseClass = true;

    function toggleNav() {
        collapseClass = !collapseClass;
    }

    $: nextLocaleUrl = currentUrl.replace(/^\/(fr|en)?(.*)$/i, `/${nextLocale}$2`);
    $: nextLocaleEmoji = nextLocale === 'en' ? '🇬🇧' : '🇫🇷';
</script>

<nav id="nav_list" class:collapse={collapseClass}>
    <a href="/" id="brand-link" title="Alex-Rock.tech">
        <img src="/favicon.png" />
    </a>

    <a href="/{$locale}/services">
        <span class="fa"></span> {$_("services.title")}
    </a>

<!--    <a href="/{$locale}/trainings">-->
<!--        <span class="fa"></span> {$_("services.training.title")}-->
<!--    </a>-->

    <a href="/{$locale}/coaching">
        <span class="fa"></span> {$_("services.coaching.title")}
    </a>

    <a href="/{$locale}/talks">
        <span class="fa"></span> {$_("services.talks.title")}
    </a>

    <a href="/{$locale}/contact">
        <span class="fa"></span> {$_("contact.title")}
    </a>

    <a href="https://www.orbitale.io/">
        <span class="fa"></span> {$_('menu.blog')}
    </a>

    <a href="{nextLocaleUrl}" id="locale_link">
        <span>{nextLocaleEmoji}</span> {nextLocale}
    </a>

    <button
        id="toggle_collapse"
        type="button"
        aria-controls="nav_list"
        aria-expanded="false"
        aria-label="{$_('toggle_navigation')}"
        on:click={toggleNav}
    >
        <i class="fa fa-bars"></i>
        <span>Menu</span>
    </button>
</nav>

<style lang="scss">
    #toggle_collapse {
        @apply sr-only;
        span {
            @apply sr-only;
        }
    }
    #nav_list {
        display: flex;
        img {
            max-height: 2em;
        }
        a, button {
            height: 2em;
            line-height: 2em;
            text-align: center;
            padding: 10px 40px;
            border: none;
            color: black;
            background: white;
            text-decoration: none;

            span {
                color: #3BABE8;
            }

            &:hover {
                color: #3BABE8;
            }

            &#locale_link {
                text-transform: uppercase;
            }
        }
    }
</style>
