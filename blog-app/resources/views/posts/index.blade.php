<x-layout>
    <x-header />
    <x-search />
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4 mb-4">
        @foreach($posts as $post)
        <x-post-card :post="$post" />
        @endforeach
    </div>
</x-layout>