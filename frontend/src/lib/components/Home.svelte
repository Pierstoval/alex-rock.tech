<script>
    import {_} from 'svelte-i18n';
</script>

<svelte:head>
    <title>Alex Rock - {$_('master_head.title')}</title>
</svelte:head>

<header>
    <div id="stars"></div>
    <div class="container">
        <img src="/img/avatar.jpg" alt="">

        <h1>Alex Rock</h1>

        <div id="moon-icon-container">
            <span></span>
            <i id="moon-icon" class="fa fa-moon"></i>
            <span></span>
        </div>

        <p id="head_text">
            {$_('master_head.title')}
        </p>
    </div>

    <div id="moon"></div>
</header>

<section class="container" id="skills">
    <h2>{$_('skills.title')}</h2>

    <div class="skills">
        <div class="col">
            {@html $_('skills.left')}
        </div>
        <div class="col">
            {@html $_('skills.right')}
        </div>
    </div>
</section>

<style lang="scss">
    header {
        @apply relative overflow-hidden text-white text-center;
        background: transparent url('/img/True_and_imagine_stars.png') repeat;
        img {
            @apply block w-52 my-10 rounded-full mx-auto;
        }
        h1 {
            @apply uppercase;
        }
        #head_text {
            @apply text-lg;
        }
    }
    #moon-icon-container {
        @apply relative mx-auto flex items-center;
        span {
            @apply w-64 bg-sky-400 border-2 border-sky-400 h-1 mx-8 rounded-full;
        }
        #moon-icon {
            @apply text-4xl my-5 text-slate-100;
        }
    }

    #stars {
        @apply absolute z-0 top-1/2 left-1/2 animate-[spin-bg_360s_linear_infinite];
        background: transparent url('/img/True_and_imagine_stars.png') repeat;
        width: 1920px;
        height: 1965px;
        margin-top: -982px;
        margin-left: -960px;
    }
    #moon {
        background: transparent url('/img/pierstoval_moon_by_lawlie.png') no-repeat top center;
        -webkit-background-size: 160px;
        background-size: 160px;
        width: 160px;
        height: 160px;
        margin: 50px auto 50px auto;
        @apply animate-[spin_270s_linear_infinite];
    }

    @-webkit-keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); } } @-moz-keyframes spin-bg { 100% { -moz-transform: rotate(-360deg); } } @keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); transform:rotate(-360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } } @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } } @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style>
