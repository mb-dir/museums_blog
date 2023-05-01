@props(['post'])

<div class="bg-gray-50 border border-gray-200 rounded p-6">
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="http://wlaczpolske.pl/pliczki/252" alt="">
        <div>
            <h3 class="text-2xl">
                <a href={{"/posts/".$post->id}}>{{$post->title}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$post->user->name}}</div>
            <ul class="flex">
                @foreach(explode(',', $post->tags) as $tag)
                <li class="flex itssems-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs">
                    {{$tag}}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>