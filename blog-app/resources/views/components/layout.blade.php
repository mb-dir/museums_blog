<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muzealne Spojrzenie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
      theme: {
        extend: {
            colors: {
                purple: "#9B4F96",
            },
            fontFamily: {
                header: ['Baumans']
            }
        },
      },
    };
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baumans&family=Dancing+Script&display=swap');
    </style>
</head>

<body>
    <nav class="sticky top-0 w-full z-20 bg-gray-50 h-14 flex justify-between items-center items-center">
        <a href="/" class="ml-4 font-bold hover:text-purple font-header">Muzealne Spojrzenie</a>
        <ul class="flex space-x-6 mr-6 text-lg">
            @auth
            <li>
                <a href={{ route('users.show', ['user'=>auth()->user()->id]) }} class="font-bold uppercase">
                    Witaj {{auth()->user()->name}}
                </a>
            </li>
            @if (auth()->user()->role === 'admin')
            <li>
                <a href={{route('adminPanel')}}>
                    Admin panel
                </a>
            </li>
            @endif
            <li>
                <form class="inline" method="POST" action=" {{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        Wyloguj się
                    </button>
                </form>
            </li>
            @else
            <li>
                <a href={{route("register")}} class="hover:text-purple">Rejestracja</a>
            </li>
            <li>
                <a href={{route("login")}} class="hover:text-purple">
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