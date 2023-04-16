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
        },
      },
    };
    </script>
</head>

<body>
    <nav class="sticky top-0 w-full z-20 bg-gray-50 h-14 flex justify-between items-center items-center">
        <a href="/layouts/index.html" class="ml-4 font-bold hover:text-purple">Strona główna</a>
        <ul class="flex space-x-6 mr-6 text-lg">
            <li>
                <a href="/layouts/register.html" class="hover:text-purple">Rejestracja</a>
            </li>
            <li>
                <a href="/layouts/login.html" class="hover:text-purple">
                    Logowanie</a>
            </li>
        </ul>
    </nav>

    <main class="h-screen">
        {{$slot}}
    </main>
    <footer
        class="w-full flex items-center justify-start font-bold bg-purple text-white h-24 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright © 2023, Wszelkie prawa zastrzeżone</p>
    </footer>

</body>

</html>