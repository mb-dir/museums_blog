<x-layout>
    <div class="text-center bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
        <div class="mb-6 flex items-center justify-center flex-col">
            <h2 class="text-2xl font-bold uppercase my-3">
                Twoje dane
            </h2>
            <ul>
                <li><span class="font-bold">nazwa</span>: {{auth()->user()->name}}</li>
                <li><span class="font-bold">email</span>: {{auth()->user()->email}}</li>
                <li><span class="font-bold">data_rejestracji</span>: {{auth()->user()->register_date}}</li>
                <li><span class="font-bold">twój score</span>: {{auth()->user()->score}}</li>
            </ul>
            <h2 class="text-2xl font-bold uppercase my-3">Twoje rangi</h2>
            <ul>
                @foreach($rankings as $rank)
                @if (auth()->user()->score >= $rank->min_score)
                <li>{{$rank->name}}</li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</x-layout>
