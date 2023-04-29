<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded">
            <div class="flex flex-col items-center justify-center text-center">
                <h3 class="text-2xl mb-2">{{$post->title}}</h3>
                <div class="text-xl font-bold mb-2">{{$post->user->name}}</div>

                {{-- TODO create component for tags --}}
                <ul class="flex mb-2">
                    @foreach(explode(',', $post->tags) as $tag)
                    <li
                        class="flex itssems-center justify-center bg-black text-white rounded-xl py-1 px-3 mr-2 text-xs">
                        <a href="/?tag={{$tag}}">{{$tag}}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="border border-gray-200 w-full mb-6"></div>
                <div>
                    <h3 class="text-3xl font-bold mb-4">
                        Treść
                    </h3>
                    <div class="text-lg space-y-6">
                        <p>{{$post->content}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>