<script>
    import { _ } from 'svelte-i18n'
    export let page;
    export let anchor;
    export let locale;
</script>

<a class="nav-link py-3 px-lg-3 rounded js-scroll-trigger" href="/{locale}/{page}">
    {$_(anchor)}
</a>
