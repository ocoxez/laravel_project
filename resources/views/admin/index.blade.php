<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Все заявки</title>
    <link rel="stylesheet" href="resources/js/app.js">
    @vite(['resources/css/reset.css'])
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/reports.css'])
</head>

<body>
<x-app-layout>
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
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>{{ $report->user->name ?? 'Пользователь удален' }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->number }}</td>
                                <td>
                                    <form class="status-form" action="{{ route('reports.status.update', $report->id) }}" method="POST" style="display: flex; gap: 5px;" >
                                        @csrf
                                        @method('patch')
                                        <select name="status_id" id="status_id" data-current-status="{{ $report->status_id }}">
                                            @foreach($statuses as $status)  
                                                <option value="{{ $status->id }}" {{ $status->id === $report->status_id ? 'selected' : ''}}>

                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
    .main {
  display: flex;
  justify-content: space-between;
  max-width: 1200px;
  padding: 0 20px;
  margin: 0 auto;
  padding: 25px 0;
  align-items: center;
  background: #fff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  position: sticky;
  top: 0;
  z-index: 100;
}
</style>
</html>