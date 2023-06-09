<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
            @if (Auth::check() && Auth::user()->status === 'active')
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Utwórz post
                </h2>
            </header>

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label for="title" class="inline-block text-lg mb-2">Tytuł</label>
                    <input required maxlength="255" type="text" id="title"
                        class="border border-gray-200 rounded p-2 w-full" name="title" placeholder="Tytuł..."
                        value="{{old('title')}}" />
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="tags" class="inline-block text-lg mb-2">
                        Tagi (oddzielone przecinkiem)
                    </label>
                    <input pattern="^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+(,\s[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]+)*$" required type="text"
                        id="tags" class="border border-gray-200 rounded p-2 w-full" name="tags" placeholder="tag1, tag2"
                        value="{{old('tags')}}" />
                    @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="content" class="inline-block text-lg mb-2">
                        Zawartość
                    </label>
                    <textarea required maxlength="2000" class="border border-gray-200 rounded p-2 w-full" id="content"
                        name="content" rows="10" placeholder="Treść...">{{old('content')}}</textarea>
                    @error('content')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="photo" class="inline-block text-lg mb-2">
                        Zdjęcie
                    </label>
                    <input required type="file" id="photo" name="photo" accept="image/jpeg, image/png" />
                    @error('photo')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <button class="bg-purple text-white rounded py-2 px-4 hover:bg-black">
                        Dodaj post
                    </button>

                    <a href="/" class="text-black ml-4"> Powrót</a>
                </div>
            </form>
            @else
            <p class="text-center py-32">Wygląda na to, że zostałeś zablokowany i nie możesz dodawać
                postów. Skontaktuj
                się z
                administratorem.</p>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/photoValid.js') }}"></script>
</x-layout>