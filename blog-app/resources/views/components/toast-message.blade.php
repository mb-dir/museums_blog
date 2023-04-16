@if(session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show.transition.duration.3000ms="show"
    class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-purple text-white z-50 px-20 py-5 rounded">
    <p>{{ session('message') }}</p>
</div>
@endif