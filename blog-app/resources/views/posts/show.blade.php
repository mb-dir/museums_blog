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
                        {{$tag}}
                    </li>
                    @endforeach
                </ul>

                @if (Auth::check() && $post->user_id == Auth::user()->id)
                <form action="/posts/{{$post->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p>Możesz usunąć swój post</p>
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ff0000" width="24"
                            height="24">
                            <path
                                d="M21 4h-4V3c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v1H3c-.6 0-1 .4-1 1s.4 1 1 1h1v14c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6h1c.6 0 1-.4 1-1s-.4-1-1-1zM8 4h8v1H8V4zm8 16H8V8h8v12z" />
                            <path d="M9 10h2v8H9zM13 10h2v8h-2z" />
                        </svg>
                    </button>
                </form>
                @endif

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