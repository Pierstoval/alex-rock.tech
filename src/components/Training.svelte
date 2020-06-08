<script>
    import { createEventDispatcher } from 'svelte';
    import {_} from 'svelte-i18n';
    import marked from "marked";

    const dispatch = createEventDispatcher();

    export let title;
    export let description;
    export let duration;

    const clickTraining = function() {
        if (this.classList.contains('selected')) {
            this.classList.remove('selected');
        } else {
            this.classList.add('selected');
        }
        dispatch('select', {
            title: this.getAttribute('data-training'),
            selected: this.classList.contains('selected'),
        });
    }
</script>

<div class="card mb-4 training-item"
     data-training="{title}"
     data-duration="{duration}"
     on:click={clickTraining}
>
    <h4 class="card-title card-header">
        {$_(title)}
    </h4>
    <div class="card-body">
        <div class="card-text">
            {@html marked($_(description))}
        </div>
    </div>
    <div class="card-footer">
        {$_('training_item.selected')}
    </div>
</div>
