<script>
    import {_} from 'svelte-i18n';
    import LilMoonHeading from "$lib/components/LilMoonHeading.svelte";
</script>

<svelte:head>
    <title>Alex Rock - {$_('master_head.title')}</title>
</svelte:head>

<header>
    <div id="stars"></div>
    <div class="container">
        <img src="/img/avatar.jpg" alt="">

        <h1>Alex Rock</h1>

        <LilMoonHeading />

        <p id="head_text">
            {$_('master_head.title')}
        </p>
    </div>

    <div id="moon"></div>
</header>

<section class="container" id="skills_container">
    <h2>{$_('skills.title')}</h2>

    <div id="skills">
        <div>
            {@html $_('skills.left')}
        </div>
        <div>
            {@html $_('skills.right')}
        </div>
    </div>
</section>

<style lang="scss">
    @-webkit-keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); } } @-moz-keyframes spin-bg { 100% { -moz-transform: rotate(-360deg); } } @keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); transform:rotate(-360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } } @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } } @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }

    header {
        @apply relative overflow-hidden text-white text-center py-10;

        background: transparent url('/img/True_and_imagine_stars.png') repeat;
        img {
            @apply block w-52 my-10 rounded-full mx-auto;
        }
        h1 {
            @apply uppercase;
        }
        #head_text {
            @apply text-lg text-heading py-4;
        }

        #stars {
            @apply absolute z-0 top-1/2 left-1/2 animate-[spin-bg_360s_linear_infinite];
            background: transparent url('/img/True_and_imagine_stars.png') repeat;
            width: 1920px;
            height: 1965px;
            margin-top: -982px;
            margin-left: -960px;
        }
    }

    #skills_container {
        @apply text-center pb-9;
        h2 {
            @apply py-7 uppercase;
        }
        #skills {
            @apply flex items-center justify-center;
            div {
                @apply px-4;
            }
        }
    }

</style>
