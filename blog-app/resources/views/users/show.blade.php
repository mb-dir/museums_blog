<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded mx-auto mt-24 mb-24">
        <div class="mb-24 flex lg:items-start lg:justify-around flex-col lg:flex-row lg:space-x-6">
            <div class="mx-5">
                <h2 class="text-2xl font-bold uppercase my-3">
                    Twoje dane
                </h2>
                <ul>
                    <li><span class="font-bold">Nazwa</span>: {{ auth()->user()->name }}</li>
                    <li><span class="font-bold">Email</span>: {{ auth()->user()->email }}</li>
                    <li><span class="font-bold">Data rejestracji</span>: {{ auth()->user()->register_date }}</li>
                    <li><span class="font-bold">Twój score</span>: {{ auth()->user()->score }}</li>
                    <li><span class="font-bold">Rola</span>: {{ auth()->user()->role }}</li>
                    <li><span class="font-bold">Status</span>: {{ auth()->user()->status }}</li>
                </ul>
                @if (auth()->user()->role === 'user')
                <h2 class="text-2xl font-bold uppercase my-3">Twoje rangi</h2>
                @if ($rankings->isEmpty())
                <p>Brak rang</p>
                @else
                <ul>
                    @foreach($rankings as $rank)
                    <li>{{ $rank->name }} {{$rank->emoji}}</li>
                    @endforeach
                </ul>
                @endif
                @endif
            </div>
            <div class="mx-5">
                <h2 class="text-2xl font-bold uppercase my-3">Twoje posty</h2>
                @if ($userPosts->isEmpty())
                <p>Brak postów</p>
                @else
                <ul class="list">
                    @foreach($userPosts as $post)
                    <li><a class="text-blue-500" href={{route('posts.show', compact('post'))}}>{{ $post->title }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <div class="mx-5">
                <h2 class="text-2xl font-bold uppercase my-3">
                    Dostępne akcje
                </h2>
                <p>Edytuj swoje dane</p>
                <a href={{route('users.update', ['user'=>auth()->user()->id])}} class="flex justify-center">
                    <x-heroicon-o-pencil class="h-6 w-6 text-blue-500" />
                </a>
            </div>
        </div>
    </div>
</x-layout>