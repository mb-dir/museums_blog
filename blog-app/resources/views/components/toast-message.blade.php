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
@php
$message = session('message');
$bgClass = '';
switch ($message['type']) {
case 'delete':
$bgClass = 'bg-red-400';
break;
case 'success':
$bgClass = 'bg-green-400';
break;
case 'info':
$bgClass = 'bg-purple';
break;
default:
$bgClass = 'bg-purple';
break;
}
@endphp
<div
    class="card-animate fixed top-0 left-1/2 transform -translate-x-1/2 {{ $bgClass }} text-white z-50 px-10 py-5 rounded text-center">
    <p>{{ $message['content'] }}</p>
</div>
@endif