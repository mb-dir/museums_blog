<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24 mb-48">
        <div class="mb-6 flex items-center justify-center flex-col">
            <h2 class="text-2xl font-bold uppercase my-3">
                Profil użytkowniak {{$user->name}}
            </h2>
            <p>Usuń użytkownika</p>
            <form action=" /users/{{$user->id}}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ff0000" width="24" height="24">
                        <path
                            d="M21 4h-4V3c0-.6-.4-1-1-1h-6c-.6 0-1 .4-1 1v1H3c-.6 0-1 .4-1 1s.4 1 1 1h1v14c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6h1c.6 0 1-.4 1-1s-.4-1-1-1zM8 4h8v1H8V4zm8 16H8V8h8v12z" />
                        <path d="M9 10h2v8H9zM13 10h2v8h-2z" />
                    </svg>
                </button>
            </form>
            <ul>
                <li><span class="font-bold">Nazwa</span>: {{$user->name }}</li>
                <li><span class="font-bold">Email</span>: {{ $user->email }}</li>
                <li><span class="font-bold">Data rejestracji</span>: {{ $user->register_date }}</li>
                <li><span class="font-bold">Score</span>: {{ $user->score }}</li>
                <li><span class="font-bold">Rola</span>: {{ $user->role }}</li>
            </ul>
            <h2 class="text-2xl font-bold uppercase my-3">Rangi</h2>
            <ul>
                @foreach($rankings as $rank)
                <li>{{ $rank->name }} {{$rank->emoji}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>