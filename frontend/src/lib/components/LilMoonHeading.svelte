<script lang="ts">
    export let dark: boolean = false;
</script>

<div id="moon-icon-container">
    <span></span>
    <i id="moon-icon" class="fa fa-moon" class:dark={dark}></i>
    <span></span>
</div>

<style lang="scss">
    #moon-icon-container {
        @apply relative max-w-[50%] mx-auto flex items-center;
        span {
            @apply w-64 bg-sky-400 border-2 border-sky-400 h-1 mx-8 rounded-full;
        }
        #moon-icon {
            @apply text-4xl my-0 text-slate-100;
            &.dark {
                @apply text-slate-900;
            }
        }
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
</style>
