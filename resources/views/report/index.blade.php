<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все заявки</title>
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/reports.css'])
</head>

<body>

    <header class="header">
        <nav class="header-nav">
            <ul class="nav-list">
                <li class="list-item">
                    <a href="/reports" class="item-link">Нарушений<span>.нет</span></a>
                </li>
            </ul>
        </nav>
        <div class="login-logout">
        </div>
    </header>
    <main class="main">
        <section class="reports">
            <a href="/reports/create" class="create-btn">Создать заявление</a>
            <div class="sort">
                <p>--------------------------------------</p>
                <span>Сортировка по дате создания: </span>
                <p>--------------------------------------</p>
                <a href="{{ route('report.index', ['sort' => 'desc', 'status' => $status]) }}" class="text-red-900">Сначала новые</a>
                <p> </p>
                <a href="{{ route('report.index', ['sort' => 'asc', 'status' => $status]) }}" class="text-red-900">Сначала старые</a>
            <div class="filters">
                <p>--------------------------------------</p>
                <p>Фильтрацию по статусу заявки</p>
                <p>--------------------------------------</p>
                <ul>
                    @foreach($statuses as $status)
                        <li>
                            <a href="{{ route('report.index',['sort' => $sort, 'status' => $status-> id])}}" class="text-blue-950">
                                {{$status->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            </div>
            <div class="cards-container">
                @foreach ($reports as $report)
                <div class="card">
                    <p class="card-created-at">{{ $report->created_at }}</p>
                    <p class="card-number">{{ $report->number }}</p>
                    <p class="card-description">{{ $report->description }}</p>
                    <div class="card-status-container">
                        <p>{{ $report->status->name }}</p>
                    </div>
                    <a class="update-btn" href="/reports/{{ $report->id }}/edit">Изменить</a>
                    <form class="form-delete" method="POST" action="{{ route('report.destroy', [$report->id]) }}">
                        @method('delete')
                        @csrf
                        <input class="delete-btn" type="submit" value="Удалить" />
                    </form>
                </div>
                @endforeach
                
            </div>
            {{$reports->links()}}
        </section>
    </main>
</body>

</html>