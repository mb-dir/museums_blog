<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded mx-auto mt-24 mb-48">
        <div class="mb-6 flex items-center justify-center flex-col">
            <h1 class="text-2xl font-bold uppercase my-3">
                Profil użytkownika {{$user->name}}
            </h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
                <div>
                    <h2 class="text-2xl font-bold uppercase my-3">Dane</h2>
                    <ul>
                        <li><span class="font-bold">Nazwa</span>: {{$user->name }}</li>
                        <li><span class="font-bold">Email</span>: {{ $user->email }}</li>
                        <li><span class="font-bold">Data rejestracji</span>: {{ $user->register_date }}</li>
                        <li><span class="font-bold">Score</span>: {{ $user->score }}</li>
                        <li><span class="font-bold">Rola</span>: {{ $user->role }}</li>
                        <li><span class="font-bold">Status</span>: {{ $user->status }}</li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-2xl font-bold uppercase my-3">Rangi</h2>
                    @if ($rankings->isEmpty())
                    <p>Brak rang</p>
                    @else
                    <ul>
                        @foreach($rankings as $rank)
                        <li>{{ $rank->name }} {{$rank->emoji}}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-bold uppercase my-3">Posty</h2>
                    @if ($userPosts->isEmpty())
                    <p>Brak postów</p>
                    @else
                    <ul class="list">
                        @foreach($userPosts as $post)
                        <li><a class="text-blue-500" href="/posts/{{$post->id}}">{{ $post->title }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                <div>
                    <h2 class="text-2xl font-bold uppercase my-3">Dostępne akcje</h2>
                    <p>Usuń użytkownika</p>
                    <form action="/users/{{$user->id}}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">
                            <x-heroicon-o-trash class="h-6 w-6 text-red-500" />
                        </button>
                    </form>

                    <p>Edytuj użytkownika</p>
                    <a href="/users/{{$user->id}}/edit" class="flex justify-center">
                        <x-heroicon-o-pencil class="h-6 w-6 text-blue-500" />
                    </a>

                    <p>
                        @if ($user->status === 'active')
                        Zablokuj użytkownika
                        @else
                        Odblokuj użytkownika
                        @endif
                    </p>
                    <form action="/users/{{$user->id}}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="">
                            <x-heroicon-o-arrow-path class="h-6 w-6 text-blue-500" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <a href="/admin-panel" class="text-black ml-4">
            <- Powrót </a>
    </div>
</x-layout>