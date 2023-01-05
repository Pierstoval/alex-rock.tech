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
    <div id="brand-collapse-container">
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
    </div>

    <div id="collapsible-nav-container">
        <ul class="collapsible" class:collapsed={collapseClass}>
            <li>
                <a href="/{$locale}/services">{$_("services.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/trainings">{$_("services.training.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/coaching">{$_("services.coaching.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/talks">{$_("services.talks.title")}</a>
            </li>

            <li>
                <a href="/{$locale}/contact">{$_("contact.title")}</a>
            </li>

            <li>
                <a href="https://www.orbitale.io/">{$_('menu.blog')}</a>
            </li>

            <li>
                <a href="{nextLocaleUrl}" id="locale_link"><span>{nextLocaleEmoji}</span> {nextLocale.toUpperCase()}</a>
            </li>
        </ul>
    </div>
</nav>

<style lang="scss">
    nav {
        #toggle_collapse {
            @apply md:sr-only;
            i {
                @apply text-xl;
            }
            span {
                @apply sr-only;
            }
        }
        .collapsible {
            @apply max-md:bg-slate-100 max-md:absolute top-0 left-0 z-50;
            &.collapsed {
                @apply max-md:max-h-0 overflow-hidden;
            }
        }

        #brand-collapse-container {
            @apply max-md:w-full max-md:flex max-md:justify-between max-md:content-center;
            a, button {
                @apply max-md:max-w-max;
            }
        }

        @apply max-md:bg-slate-50 justify-between items-center flex max-md:flex-col;
        #collapsible-nav-container {
            @apply relative w-full;
        }

        img {
            @apply max-h-10 inline-block m-1;
        }
        ul {
            @apply flex max-md:flex-col justify-end items-center;
            &, li {
                @apply list-none text-center;
                &, a, button {
                    @apply max-md:w-full;
                }
            }
        }
        a, button {
            @apply inline-block text-center leading-8 mx-1 px-2;
            &:not(#brand-link) {
                @apply py-2;
            }

            span, &:hover {
                @apply text-blue-400;
            }
        }
    }
</style>
