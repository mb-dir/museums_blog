<x-layout>
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
</x-layout>