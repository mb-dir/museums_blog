@props(['tags'])

<ul class="flex mb-2">
    @foreach(explode(',', $tags) as $tag)
    <li class="flex itssems-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs">
        {{$tag}}
    </li>
    @endforeach
</ul>