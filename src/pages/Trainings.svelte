<script>
    import {_, locale} from 'svelte-i18n';
    import marked from "marked";
    import Training from '../components/Training.svelte';

    const max_number_of_students = 20;
    const max_number_of_days = 20;

    let number_of_students = 1;
    let number_of_days = 1;
    let disable_days_selector = false;
    let final_price = '-';

    const trainings = [
        {
            title : "training_item.php_discover",
            duration : 5,
            description : 'training_item.php_discover_text',
            selected: false,
        },
        {
            title : "training_item.php_oop",
            duration : 5,
            description : 'training_item.php_oop_text',
            selected: false,
        },
        {
            title : "training_item.symfony_discover",
            duration : 5,
            description : 'training_item.symfony_discover_text',
            selected: false,
        },
        {
            title : "training_item.symfony_advanced",
            duration : 5,
            description : 'training_item.symfony_advanced_text',
            selected: false,
        },
    ];

    function selectPrice(options) {
        const title = options.detail.title;
        const selected = options.detail.selected;

        const training = trainings.filter((t) => t.title === title)[0];
        training.selected = selected;

        recalculatePrices();
    }

    function recalculatePrices() {
        let days_with_selected_trainings = 0;

        trainings.map((t) => {
            if (t.selected) {
                days_with_selected_trainings += t.duration;
            }
        });

        disable_days_selector = false;
        if (days_with_selected_trainings) {
            number_of_days = days_with_selected_trainings;
            disable_days_selector = true;
        }

        const price = (200 * (number_of_days + number_of_students)) * 1.5;

        final_price = price + ' €';
    }

    function chunks(array, size) {
        return Array.apply(0,{length: Math.ceil(array.length / size)}).map((_, index) => array.slice(index*size, (index+1)*size))
    }

    const chunked_array = chunks(trainings, 2);
</script>

<section class="page-section" id="trainings">
    <div class="container">

        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">
            {$_('services.training.title')}
        </h2>

        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>

        <p>
            {@html marked($_('services.training.description'))}
        </p>

        <h2>{$_('services.training.courses')}</h2>

        {#each chunked_array as _trainings}
            <div class="card-deck">
                {#each _trainings as training}
                    <Training
                        on:select={selectPrice}
                        title="{training.title}"
                        duration={training.duration}
                        description={training.description}
                    />
                {/each}
            </div>
        {/each}

        <p class="alert alert-info">{$_('services.trainings.more_and_custom')}</p>

        <h2>{$_('services.training.prices')}</h2>

        <p>{@html marked($_('services.training.text'))}</p>

        <div class="row">
            <div class="col-sm-6 mx-auto">
                <label for="number-of-students">
                    {$_('trainings.number_of_students')}
                    <div class="number-container" id="number-of-students-value">{number_of_students}</div>
                </label>
                <input type="range" min="1" max="{max_number_of_students}" class="custom-range" name="number-of-students" id="number-of-students" bind:value={number_of_students} on:change={recalculatePrices}>
            </div>
            <div class="col-sm-6 mx-auto">
                <label for="number-of-days">
                    {$_('trainings.number_of_days')}
                    <div class="number-container" id="number-of-days-value">{number_of_days}</div>
                </label>
                <input type="range" min="1" max="{max_number_of_days}" class="custom-range" name="number-of-days" id="number-of-days" bind:value={number_of_days} on:change={recalculatePrices} disabled={disable_days_selector}>
            </div>
            <div class="col-sm-12">
                <div class="text-center">{$_('trainings.final_price')}</div>
                <div id="final-price" class="text-center">{final_price}</div>
                <!--
                Formula is:
                training price = (200 * (days + students)) * 1.5
                Send me an email if you see this message, I like feedback :)
                -->
                <div id="trainings-list-container" class="hide text-center">
                    {$_('trainings.choosen_list')}
                    <ul class="trainings-list"></ul>
                    <a data-href-base="/{$locale}/contact" class="btn btn-primary btn-lg" id="training-booking-button">
                        {$_('trainings.book_button')}
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>
