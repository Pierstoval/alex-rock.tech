<script>
    import {_} from 'svelte-i18n';
</script>

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
            <div class="col-lg-4 ml-auto">
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
