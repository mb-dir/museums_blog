<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muzealne Spojrzenie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
      theme: {
        extend: {
          colors: {
            purple: "#9B4F96",
          },
        },
      },
    };
    </script>
</head>

<body>
    <nav class="sticky top-0 w-full z-20 bg-gray-50 h-14 flex justify-between items-center items-center">
        <a href="/" class="ml-4 font-bold hover:text-purple">Strona główna</a>
        <ul class="flex space-x-6 mr-6 text-lg">
            @auth
            <li>
                <a href="/user-info" class="font-bold uppercase">
                    Welcome {{auth()->user()->name}}
                </a>
            </li>
            <li>
                <form class="inline" method="POST" action="/logout">
                    @csrf
                    <button type="submit">
                        Logout
                    </button>
                </form>
            </li>
            <li>
                {{-- {{auth()->user()->rankings}}
                @foreach(auth()->user()->rankings as $role)
                @if (auth()->user()->score >= $role->min_score)
                {{$role->name}}
                @endif
                @endforeach --}}
            </li>
            @else
            <li>
                <a href="register" class="hover:text-purple">Rejestracja</a>
            </li>
            <li>
                <a href="login" class="hover:text-purple">
                    Logowanie</a>
            </li>
            @endauth
        </ul>
    </nav>

    <main>
        {{$slot}}
    </main>
    <footer
        class="w-full flex items-center justify-start font-bold bg-purple text-white h-24 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright © 2023, Wszelkie prawa zastrzeżone</p>
    </footer>

    <x-toast-message />

</body>

</html>
