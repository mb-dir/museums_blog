<style>
    .card-animate {
        opacity: 0;
        animation: hide 4s ease-in-out;
    }

    @keyframes hide {
        0% {
            opacity: 1;
        }

        90% {
            opacity: .9;
        }

        100% {
            opacity: 0;
        }
    }
</style>

@if(session()->has('message'))
<div class="card-animate fixed top-0 left-1/2 transform -translate-x-1/2 bg-purple text-white z-50 px-20 py-5 rounded">
    <p>{{ session('message') }}</p>
</div>
@endif