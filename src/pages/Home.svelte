<script>
    import {_} from 'svelte-i18n';
    import Skills from "./Skills.svelte";
</script>

<svelte:head>
    <title>{$_('master_head.title')}</title>
</svelte:head>

<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">

        <img class="masthead-avatar mb-5" src="/img/avatar.jpg" alt="">

        <h1 class="masthead-heading text-uppercase mb-0">Alex Rock</h1>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>

        <p class="masthead-subheading font-weight-light mb-0">
            {$_('master_head.title')}
        </p>
    </div>
</header>

<Skills/>
