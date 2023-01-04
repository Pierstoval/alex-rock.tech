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

<nav id="nav_list">
    <a href="/" id="brand-link" title="Alex-Rock.tech">
        <img src="/favicon.png" alt="Alex-Rock.tech brand image" />
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

    <div id="rel-container">
        <ul class="collapsible" class:collapsed={collapseClass}>
            <li>
                <a href="/{$locale}/services"><span class="fa"></span> {$_("services.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/trainings"><span class="fa"></span> {$_("services.training.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/coaching"><span class="fa"></span> {$_("services.coaching.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/talks"><span class="fa"></span> {$_("services.talks.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/contact"><span class="fa"></span> {$_("contact.title")}</a>
            </li>

            <li>
                <a href="https://www.orbitale.io/"><span class="fa"></span> {$_('menu.blog')}</a>
            </li>

            <li>
                <a href="{nextLocaleUrl}" id="locale_link"><span>{nextLocaleEmoji}</span> {nextLocale}</a>
            </li>
        </ul>
    </div>
</nav>

<style lang="scss">
    #toggle_collapse {
        @apply md:sr-only;
        i {
            font-size: 2em;
        }
        span {
            @apply sr-only;
        }
    }
    .collapsible {
        @apply max-md:absolute;
        top: 0;
        left: 0;
        background: white;
        z-index: 99999;
        &.collapsed {
            @apply max-md:max-h-0;
            @apply overflow-hidden;
        }
    }

    nav {
        * { background: #eee; }
        justify-content: space-between;
        align-items: center;
        @apply flex;
        @apply max-md:flex-col;
        #rel-container {
            @apply relative;
            @apply w-full;
        }

        img {
            max-height: 2.5rem;
            min-width: 2.5rem;
            display: inline-block;
            @apply m-1;
        }
        ul, li {
            list-style: none;
            text-align: center;
        }
        ul {
            display: flex;
            @apply max-md:flex-col;
            align-items: center;
        }
        ul, li, a, button {
            @apply max-md:w-full;
        }
        a, button {
            display: inline-block;
            text-align: center;
            @apply leading-8;
            @apply mx-1;
            @apply px-2;
            &:not(#brand-link) {
                @apply py-2;
            }

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
