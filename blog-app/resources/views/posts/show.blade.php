<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded">
            <div class="flex flex-col items-center justify-center text-center">
                <h3 class="text-2xl mb-2">{{$post->title}}</h3>
                <div class="text-xl font-bold mb-2">{{$post->user->name}}</div>

                <x-tags :tags="$post->tags" />

                @if (Auth::check() && $post->user_id == Auth::user()->id || (Auth::check() && Auth::user()->role ===
                'admin'))
                <p>Możesz edytować post</p>
                <a href="/posts/{{$post->id}}/edit">
                    <x-heroicon-o-pencil class="h-6 w-6 text-blue-500" />
                </a>
                <form action="/posts/{{$post->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p>Możesz usunąć post</p>
                    <button type="submit" class="text-red-500 hover:text-red-700">
                        <x-heroicon-o-trash class="h-6 w-6 text-red-500" />
                    </button>
                </form>
                @endif

                <div class="border border-gray-200 w-full mb-6"></div>
                <div class="flex justify-center items-center">
                    <img src="{{asset('storage/'.$post->photo)}}" alt="" class="mb-5">
                </div>
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
    <div class="bg-gray-50 border border-gray-200 p-10 mt-10 rounded">
        <div class="flex flex-col items-center justify-center text-center">
            <h3 class="text-3xl font-bold mb-4">Komentarze</h3>
            <div class="space-y-4">
                @foreach ($comments as $comment)
                <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                    <strong>{{$comment->user->name}}</strong> <span
                        class="text-xs text-gray-400">{{$comment->date}}</span>
                    <p class="text-sm">
                        {{$comment->content}}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex mx-auto items-center justify-center mt-10 mx-8 mb-4 max-w-lg">
        @if (Auth::check() && auth()->user()->status === 'active')
        <form action="/posts/{{$post->id}}/comments" method="POST"
            class="w-full max-w-xl bg-white rounded-lg px-4 pt-2">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <h2 class="px-4 pt-3 pb-2 text-gray-800 text-lg">Dodaj nowy komentarz</h2>
                <div class="w-full md:w-full px-3 mb-2 mt-2">
                    <textarea
                        class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                        name="content" placeholder="Treść komentarza..." required=""></textarea>
                </div>
                <div class="w-full md:w-full flex items-start md:w-full px-3">
                    <button class="bg-purple text-gray-100 p-2 rounded">Skomentuj</button>
                </div>
            </div>
        </form>
        @elseif (Auth::check() && auth()->user()->status === 'blocked')
        <p class="text-center py-32">Wygląda na to, że zostałeś zablokowany i nie możesz dodawać
            komentarzy. Skontaktuj
            się z
            administratorem.</p>
        @else
        <p class="text-center py-32">Zaloguj się aby dodać komentarz</p>
        @endif
    </div>
</x-layout>