<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Rejestracja
                </h2>
                <p class="mb-4">Stwórz konto</p>
            </header>

            <form method="POST" action="/users">
                @csrf
                <div class="mb-6">
                    <label for="name" class="inline-block text-lg mb-2">
                        Imie
                    </label>
                    <input type="text" id="name" class="border border-gray-200 rounded p-2 w-full" name="name"
                        value="{{old('name')}}" />
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="email" class="inline-block text-lg mb-2">Email</label>
                    <input type="email" id="email" class="border border-gray-200 rounded p-2 w-full" name="email"
                        value="{{old('email')}}" />
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="inline-block text-lg mb-2">
                        Hasło
                    </label>
                    <input type="password" id="password" class="border border-gray-200 rounded p-2 w-full"
                        name="password" />
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password2" class="inline-block text-lg mb-2">
                        Powtórz hasło
                    </label>
                    <input type="password" id="password_confirmation" class="border border-gray-200 rounded p-2 w-full"
                        name="password_confirmation" />
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button type="submit" class="bg-purple text-white rounded py-2 px-4 hover:bg-black">
                        Dalej
                    </button>
                </div>

                <div class="mt-8">
                    <p>
                        Masz już konto? Nie czekaj
                        <a href="/layouts/login.html" class="bg-purple p-2 text-gray-100 rounded">zaloguj
                            się</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-layout>