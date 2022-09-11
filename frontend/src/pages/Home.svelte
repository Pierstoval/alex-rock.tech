<script>
    import {_} from 'svelte-i18n';
</script>

<style>
    img.masthead-avatar {
        border-radius: 50%;
    }
    header.masthead {
        position: relative;
        overflow: hidden;
        background: transparent url('/img/True_and_imagine_stars.png') repeat;
    }
    header.masthead .container {
        position: relative;
        z-index: 1;
    }

    #stars {
        position: absolute;
        z-index: 0;
        background: transparent url('/img/True_and_imagine_stars.png') repeat;
        width: 1920px;
        height: 1965px;
        top: 50%;
        left: 50%;
        margin-top: -982px;
        margin-left: -960px;
        -webkit-animation: spin-bg 360s linear infinite;
        -moz-animation: spin-bg 360s linear infinite;
        animation: spin-bg 360s linear infinite;
    }
    #moon {
        background: transparent url('/img/pierstoval_moon_by_lawlie.png') no-repeat top center;
        -webkit-background-size: 160px;
        background-size: 160px;
        width: 160px;
        height: 160px;
        margin: 50px auto 50px auto;
        -webkit-animation: spin 270s linear infinite;
        -moz-animation: spin 270s linear infinite;
        animation: spin 270s linear infinite;
    }

    @-webkit-keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); } } @-moz-keyframes spin-bg { 100% { -moz-transform: rotate(-360deg); } } @keyframes spin-bg { 100% { -webkit-transform: rotate(-360deg); transform:rotate(-360deg); } }
    @-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } } @-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } } @keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style>

<svelte:head>
    <title>{$_('master_head.title')}</title>
</svelte:head>

<header class="masthead text-white text-center pb-0">
    <div id="stars"></div>
    <div class="container d-flex align-items-center flex-column">

        <img class="masthead-avatar mb-5" src="/img/avatar.jpg" alt="">

        <h1 class="masthead-heading text-uppercase mb-0">Alex Rock</h1>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fas fa-moon"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>

        <p class="masthead-subheading font-weight-light mb-0">
            {$_('master_head.title')}
        </p>
    </div>

    <div id="moon"></div>
</header>

<section class="page-section bg-primary text-white mb-0" id="skills">
    <div class="container">
        <h2 class="page-section-heading text-center text-uppercase text-white">{$_('skills.title')}</h2>

        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fas fa-moon"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>

        <div class="row">
            <div class="col-lg-4 offset-2 ml-auto">
                <p class="lead text-center">
                    {@html $_('skills.left')}
                </p>
            </div>
            <div class="col-lg-4 mr-auto">
                <p class="lead text-center">
                    {@html $_('skills.right')}
                </p>
            </div>
        </div>

    </div>
</section>
