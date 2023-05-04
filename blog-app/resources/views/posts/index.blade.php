<x-layout>
    <x-header />
    <x-search />
    @if (auth()->user())
    @foreach($rankings as $rank)
    @if (auth()->user()->score >= $rank->min_score)
    {{$rank->name}}
    @endif
    @endforeach
    @endif
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4 mb-4">
        @foreach($posts as $post)
        <x-post-card :post="$post" />
        @endforeach
    </div>
    <div class="mt-6 p-4">{{$posts->links()}}</div>
</x-layout>
