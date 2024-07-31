<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Google</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .map-container {
            width: 100%;
            height: 450px;
            /* lub inną wartość, którą chcesz ustawić */
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">Informacje kontaktowe</h1>
            <p class="mb-2"><strong>E-mail:</strong> www@www.pl</p>
            <p class="mb-2"><strong>Tel:</strong> 123-456-789</p>
            <p class="mb-4"><strong>Siedziba firmy:</strong></p>
            <div class="map-container aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-md">
                <iframe class="w-full h-full"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1461.5776477321426!2d21.07843243523686!3d51.969133872665715!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4719265d51a84409%3A0xf8abce121a5550ca!2sKalinowa%209%2C%2005-505%20Bronis%C5%82aw%C3%B3w!5e0!3m2!1spl!2spl!4v1712593187429!5m2!1spl!2spl"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</body>

</html>
