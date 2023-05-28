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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
                        version="1.1" id="Capa_1" width="20px" height="20px" viewBox="0 0 494.936 494.936"
                        xml:space="preserve">
                        <g>
                            <g>
                                <path
                                    d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157    c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21    s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741    c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z" />
                                <path
                                    d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069    c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963    c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692    C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107    l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005    c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z" />
                            </g>
                        </g>
                    </svg>
                </a>
                <form action="/posts/{{$post->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p>Możesz usunąć post</p>
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
    </div>
</x-layout>