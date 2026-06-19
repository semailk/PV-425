<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Интернет-магазин</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body style="font-family: 'Inter', sans-serif; margin: 0; padding: 0; background: #f8f9fa;">

<!-- Header -->
@include('components.header')

@yield('content')

<!-- Footer -->
@include('components.footer')

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        // Поиск с автозаполнением (заглушка)
        let searchTimeout;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();
            if (query.length >= 2) {
                searchTimeout = setTimeout(function() {
                    // Заглушка: показываем пример результатов
                    let html = '';
                    for (let i = 1; i <= 3; i++) {
                        html += `
                                <a href="#" class="search-result__item">
                                    <img src="#" alt="Товар ${i}">
                                    <div>
                                        <div>Товар ${i}</div>
                                        <div>${(1000 * i).toLocaleString()} ₽</div>
                                    </div>
                                </a>
                            `;
                    }
                    $('#search-results').html(html).show();
                }, 300);
            } else {
                $('#search-results').hide();
            }
        });

        // Закрытие результатов поиска при клике вне
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-search').length) {
                $('#search-results').hide();
            }
        });

        // Корзина при наведении
        $('#cart-toggle').hover(
            function() {
                // Заглушка: показываем корзину с сообщением
                $('#cart-items').html('<div class="cart-dropdown__empty">Корзина пуста</div>');
                $('#cart-dropdown').fadeIn(200);
            },
            function() {
                setTimeout(() => $('#cart-dropdown').fadeOut(200), 300);
            }
        );
        $('#cart-dropdown').hover(
            function() { $(this).stop(true, true).fadeIn(200); },
            function() { $(this).stop(true, true).fadeOut(200); }
        );

        // Каталог меню
        $('#catalog-toggle').hover(
            function() { $('#catalog-dropdown').stop(true, true).slideDown(200); },
            function() { $('#catalog-dropdown').stop(true, true).slideUp(200); }
        );
        $('#catalog-dropdown').hover(
            function() { $(this).stop(true, true).slideDown(200); },
            function() { $(this).stop(true, true).slideUp(200); }
        );
    });
</script>
</body>
</html>
