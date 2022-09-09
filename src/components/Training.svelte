<script>
    import {_} from 'svelte-i18n';
    import {marked} from "marked";

    export let title;
    export let description;
    export let duration;
</script>

<div class="card mb-4 training-item"
     data-training="{title}"
     data-duration="{duration}"
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
