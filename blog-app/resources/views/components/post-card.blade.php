@props(['post'])

<div class="bg-gray-50 border border-gray-200 rounded p-6">
    <div class="flex">
        <img class="hidden w-48 mr-6 md:block" src="{{asset('storage/'.$post->photo)}}" alt="Post Photo">
        <div>
            <h3 class="text-2xl">
                <a href={{"/posts/".$post->id}}>{{$post->title}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$post->user->name}}</div>
            <x-tags :tags="$post->tags" />
        </div>
    </div>
</div>