<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Все заявки</title>
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
<x-app-layout>
    <header class="header">
        <nav class="header-nav">
            <ul class="nav-list">
                <li class="list-item">
                    <a href="/admin" class="item-link">Нарушений<span>.нет</span> - Админ</a>
                </li>
            </ul>
        </nav>
        <div class="login-logout">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Выход</button>
                </form>
            @endauth
        </div>
    </header>

    <main class="main">
        <section class="admin-reports">
            <h2>Все заявки</h2>

            <div class="sort-filter-controls" style="margin-bottom: 20px;">
                <div class="sort">
                    <span>Сортировка по дате: </span>
                    <a href="{{ route('admin.index', ['sort' => 'desc', 'status' => $statusId]) }}">Сначала новые</a> |
                    <a href="{{ route('admin.index', ['sort' => 'asc', 'status' => $statusId]) }}">Сначала старые</a>
                </div>

                <div class="filters" style="margin-top: 10px;">
                    <span>Фильтр по статусу: </span>
                    <a href="{{ route('admin.index', ['sort' => $sort]) }}">Все</a>
                    @foreach($statuses as $status)
                        | <a href="{{ route('admin.index', ['sort' => $sort, 'status' => $status->id]) }}"
                           style="{{ $status->id == $statusId ? 'font-weight: bold; color: green;' : '' }}">
                            {{$status->name}}
                        </a>
                    @endforeach
                </div>
            </div>
            
            @if(session('success'))
                <div style="color: green; margin-bottom: 10px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-container">
                <table >
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>ФИО</th>
                            <th>Текст заявления</th>
                            <th>Номер автомобиля</th>
                            <th>Статус</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $report->user->name ?? 'Пользователь удален' }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->number }}</td>
                                <td>
                                    <strong>{{ $report->status->name ?? 'Нет статуса' }}</strong>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.report.update', $report) }}" style="display: flex; gap: 5px;">
                                        @csrf
                                        @method('PUT')
                                        <select name="status_id" required>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" 
                                                        {{ $report->status_id == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" style="padding: 5px 10px; cursor: pointer;">Обновить</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 10px; border: 1px solid #ddd; text-align: center;">Заявок не найдено.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $reports->links() }}
            </div>
        </section>
    </main>
</x-app-layout>
</body>
<style>
    th{
        padding: 10px;
        border: 1px solid black;
    }
    td{
        padding: 10px;
        border: 1px solid black;
    }
    table{
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
</style>
</html>