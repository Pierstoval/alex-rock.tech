<script>
    import {_, locale} from 'svelte-i18n';
    import marked from "marked";
</script>

<section class="page-section portfolio" id="services">
    <div class="container">

        <div class="justify-content-center">

            <h2 class="page-section-heading text-center text-secondary text-uppercase mb-0">
                {$_('services.development.title')}
            </h2>

            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon">
                    <i class="fas fa-moon"></i>
                </div>
                <div class="divider-custom-line"></div>
            </div>

            <div class="mb-2 text-justify no-p-margin">
                {@html marked($_('services.development.description').replace("\n", '<br>'))}
                <br>
                {@html marked($_('services.development.side_note').replace("\n", '<br>'))}
            </div>

            <a href="/{$locale}/contact" class="btn btn-primary btn-xl btn-outline-light">
                {$_('service_item_button')}
            </a>

        </div>

    </div>
</section>
