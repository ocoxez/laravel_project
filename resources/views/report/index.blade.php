<!DOCTYPE html>
<html lang="ru" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Все заявки | Нарушений.нет</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.flash-messages')
</head>

<body class="h-full font-sans antialiased text-slate-600">
    <x-app-layout>
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900">Заявления</h1>
                    </div>
                    <a href="/reports/create" class="inline-block px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-md shadow-red-500/20 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Создать заявление
                    </a>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
                    <div class="flex flex-col lg:flex-row gap-6 justify-between items-start lg:items-center">
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Сортировка</span>
                            <div class="flex gap-2">
                                <a href="{{ route('report.index', ['sort' => 'desc', 'status' => request('status')]) }}" 
                                   class="px-4 py-2 text-sm rounded-lg border border-transparent {{ request('sort') == 'desc' || !request('sort') ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }} transition-colors">
                                    Сначала новые
                                </a>
                                <a href="{{ route('report.index', ['sort' => 'asc', 'status' => request('status')]) }}" 
                                   class="px-4 py-2 text-sm rounded-lg border border-transparent {{ request('sort') == 'asc' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }} transition-colors">
                                    Сначала старые
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto overflow-x-auto">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Статус</span>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('report.index', ['sort' => request('sort')]) }}"
                                   class="px-4 py-2 text-sm rounded-full border {{ !request('status') ? 'bg-blue-50 border-blue-200 text-blue-700 font-medium' : 'border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' }} transition-all">
                                    Все
                                </a>
                                @foreach($statuses as $statusItem)
                                    <a href="{{ route('report.index', ['sort' => request('sort'), 'status' => $statusItem->id])}}" 
                                       class="px-4 py-2 text-sm rounded-full border whitespace-nowrap transition-all
                                       {{ request('status') == $statusItem->id 
                                            ? 'bg-blue-50 border-blue-200 text-blue-700 font-medium' 
                                            : 'border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' 
                                       }}">
                                        {{ $statusItem->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($reports as $report)
                    <div class="group flex flex-col bg-white rounded-xl border border-gray-200 hover:border-blue-300 shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">
                                    Заявка №{{ $report->number }}
                                </span>
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    {{ \Carbon\Carbon::parse($report->created_at)->format('d.m.Y') }}
                                </span>
                            </div>
                            
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 rounded-md text-sm font-semibold 
                                    {{ $report->status->name === 'Новое' ? 'bg-amber-50 text-amber-700 border border-amber-100' : '' }}
                                    {{ $report->status->name === 'Отклонено' ? 'bg-red-50 text-red-700 border border-red-100' : '' }}
                                    {{ $report->status->name === 'Решено' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : '' }}
                                    bg-slate-50 text-slate-700 border border-slate-100">
                                    {{ $report->status->name }}
                                </span>
                            </div>

                            <p class="text-slate-600 text-base leading-relaxed line-clamp-3 mb-4 flex-grow">
                                {{ $report->description }}
                            </p>
                        </div>

                        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex justify-between items-center rounded-b-xl">
                            <a href="/reports/{{ $report->id }}/edit" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                                Изменить
                            </a>

                            <form method="POST" action="{{ route('report.destroy', [$report->id]) }}" onsubmit="return confirm('Вы уверены, что хотите удалить это заявление?');">
                                @method('delete')
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors cursor-pointer">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $reports->links() }}
                </div>

            </div>
        </main>
    </x-app-layout>
</body>
</html>