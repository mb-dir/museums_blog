<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24 mb-48">
        <div class="mb-6 flex items-center justify-center flex-col">
            <h2 class="text-2xl font-bold uppercase my-3">
                Twoje dane
            </h2>
            <ul>
                <li><span class="font-bold">Nazwa</span>: {{auth()->user()->name}}</li>
                <li><span class="font-bold">Email</span>: {{auth()->user()->email}}</li>
                <li><span class="font-bold">Data rejestracji</span>: {{auth()->user()->register_date}}</li>
                <li><span class="font-bold">Twój score</span>: {{auth()->user()->score}}</li>
            </ul>
            <h2 class="text-2xl font-bold uppercase my-3">Twoje rangi</h2>
            <ul>
                @foreach($rankings as $rank)
                <li>{{$rank->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>