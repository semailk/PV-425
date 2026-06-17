<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Категории электроники</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 42px;
            font-weight: 700;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 18px;
            opacity: 0.9;
            margin-top: 10px;
            font-weight: 300;
        }

        .stats {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px 25px;
            display: inline-block;
            margin-top: 15px;
            font-size: 16px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .category-card {
            background: white;
            border-radius: 16px;
            padding: 24px 28px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 5px solid #667eea;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100px;
            height: 100px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .category-id {
            display: inline-block;
            background: #667eea;
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 2px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .category-name {
            font-size: 22px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 12px;
        }

        .category-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 14px;
            color: #666;
        }

        .status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-active::before {
            content: '●';
            color: #28a745;
            font-size: 10px;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-inactive::before {
            content: '●';
            color: #dc3545;
            font-size: 10px;
        }

        .date {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #888;
            font-size: 13px;
        }

        .date svg {
            width: 14px;
            height: 14px;
            fill: #888;
        }

        .empty-state {
            text-align: center;
            color: white;
            padding: 60px 20px;
        }

        .empty-state h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .empty-state p {
            opacity: 0.8;
        }

        @media (max-width: 640px) {
            .header h1 {
                font-size: 30px;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .category-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📱 Категории электроники</h1>
        <p>Управление категориями товаров</p>
        <div class="stats">
            Всего категорий: <strong>{{ count($categories) }}</strong>
        </div>
    </div>

    @if(count($categories) > 0)
        <div class="categories-grid">
            @foreach($categories as $category)
                <div class="category-card">
                    <span class="category-id">#{{ $category->id }}</span>
                    <div class="category-name">{{ $category->name }}</div>
                    <div class="category-meta">
                            <span class="status {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $category->is_active ? 'Активная' : 'Не активная' }}
                            </span>
                        <span class="date">
                                <svg viewBox="0 0 24 24" width="14" height="14">
                                    <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/>
                                </svg>
                                {{ \Carbon\Carbon::parse($category->created_at)->format('d.m.Y') }}
                            </span>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <h2>😕 Категории не найдены</h2>
            <p>Добавьте категории в базу данных</p>
        </div>
    @endif
</div>
</body>
</html>
