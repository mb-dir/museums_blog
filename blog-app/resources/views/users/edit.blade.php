<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    @if (Auth::user()->role === 'admin')
                    Edytuj profil użytkownika {{$user->name}}
                    @else
                    Edytuj swoje dane
                    @endif
                </h2>
            </header>

            <form method="POST" action="{{ route('users.update', compact('user')) }}">
                @csrf
                @method("PUT")
                <div class="mb-6">
                    <label for="name" class="inline-block text-lg mb-2">
                        Nazwa użytkownika
                    </label>
                    <input required minlength="3" maxlength="50" type="text" id="name"
                        class="border border-gray-200 rounded p-2 w-full" name="name" value="{{$user->name}}" />
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="inline-block text-lg mb-2">Email</label>
                    <input required type="email" id="email" class="border border-gray-200 rounded p-2 w-full"
                        name="email" value="{{$user->email}}" />
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button class="bg-purple text-white rounded py-2 px-4 hover:bg-black">
                        Zapisz
                    </button>
                    {{-- if user is admin and doesn't edit his profie --}}
                    @if (Auth::user()->role === 'admin' && Auth::id() !== $user->id)
                    <a href={{route('adminPanel.users.show', compact('user'))}} class="text-black ml-4"> Powrót</a>
                    @else
                    <a href={{route('users.show', compact('user'))}} class="text-black ml-4"> Powrót</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-layout>