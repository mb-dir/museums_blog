<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24 mb-24">
        <div class="mb-6 flex items-center justify-center flex-col">
            <h2 class="text-2xl font-bold uppercase my-3">
                Twoje dane
            </h2>
            <ul>
                <li><span class="font-bold">Nazwa</span>: {{ auth()->user()->name }}</li>
                <li><span class="font-bold">Email</span>: {{ auth()->user()->email }}</li>
                <li><span class="font-bold">Data rejestracji</span>: {{ auth()->user()->register_date }}</li>
                <li><span class="font-bold">Twój score</span>: {{ auth()->user()->score }}</li>
                <li><span class="font-bold">Rola</span>: {{ auth()->user()->role }}</li>
            </ul>
            @if (auth()->user()->role === 'user')
            <h2 class="text-2xl font-bold uppercase my-3">Twoje rangi</h2>
            <ul>
                @foreach($rankings as $rank)
                <li>{{ $rank->name }} {{$rank->emoji}}</li>
                @endforeach
            </ul>
            @endif
            <h2 class="text-2xl font-bold uppercase my-3">Twoje posty</h2>
            <ul class="list-disc">
                @foreach($userPosts as $post)
                <li><a class="text-blue-500" href="/posts/{{$post->id}}">{{ $post->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    @if (auth()->user()->role === 'admin')
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mb-48">
        <div class="mb-6 flex items-center justify-center flex-col">
            <div>
                <h2 class="text-2xl font-bold uppercase my-3">Admin panel</h2>
                <h3 class="text-2xl font-bold uppercase my-3">Lista użytkowników</h3>
                <ul class="w-full">
                    @foreach($users as $user)
                    <li class="border-b-2 w-full">
                        <a href={{"/users/".$user->id}}>{{ $user->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</x-layout>