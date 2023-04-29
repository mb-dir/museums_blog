<x-layout>
    <div class="mx-4">
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Utwórz post
                </h2>
            </header>

            <form method="POST" action="/posts">
                @csrf
                <div class="mb-6">
                    <label for="title" class="inline-block text-lg mb-2">Tytuł</label>
                    <input type="text" id="title" class="border border-gray-200 rounded p-2 w-full" name="title"
                        placeholder="Tytuł..." value="{{old('title')}}" />
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="tags" class="inline-block text-lg mb-2">
                        Tagi (oddzielone przecinkiem)
                    </label>
                    <input type="text" id="tags" class="border border-gray-200 rounded p-2 w-full" name="tags"
                        placeholder="tag1, tag2" value="{{old('tags')}}" />
                    @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="content" class="inline-block text-lg mb-2">
                        Zawartość
                    </label>
                    <textarea class="border border-gray-200 rounded p-2 w-full" id="content" name="content" rows="10"
                        placeholder="Treść..." value="{{old('content')}}"></textarea>
                    @error('content')
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
        </div>
    </div>
</x-layout>