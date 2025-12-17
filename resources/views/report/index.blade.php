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

                <x-filter :sort="$sort" :status="$status" />

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
                                <x-status :type="$report->status->id">
                                    {{ $report->status->name }}
                                </x-status>
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