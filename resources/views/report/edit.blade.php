@include('layouts.flash-messages')
<!DOCTYPE html>
<html lang="ru" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование заявки | Нарушений.нет</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.flash-messages')
</head>

<body class="h-full font-sans antialiased text-slate-600">
    <x-app-layout>
        
        <main class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
                
                <div class="w-full max-w-lg bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    
                    <div class="px-8 py-6 border-b border-gray-100 bg-slate-50/50 flex justify-between items-center">
                        <div>
                            <h1 class="text-xl font-bold text-slate-900">Редактирование</h1>
                            <p class="mt-1 text-sm text-slate-500">Изменение данных заявки</p>
                        </div>
                        <span class="bg-gray-200 text-gray-600 text-xs font-bold px-2 py-1 rounded uppercase">
                            № {{ $report->number }}
                        </span>
                    </div>

                    <div class="p-8">
                        <form class="space-y-6" method="POST" action="{{ route('reports.update', $report->id) }}">
                            @csrf
                            @method('put')
                            
                            <div>
                                <label for="number" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Регистрационный номер авто
                                </label>
                                <input 
                                    value="{{ $report->number }}"
                                    type="text" 
                                    name="number" 
                                    id="number" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 bg-gray-50 focus:bg-white transition-all duration-200 placeholder-gray-400"
                                    placeholder="Введите номер"
                                    required
                                >
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Описание нарушения
                                </label>
                                <div class="mt-1">
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        rows="4" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 bg-gray-50 focus:bg-white transition-all duration-200 placeholder-gray-400 resize-none"
                                        placeholder="Описание"
                                        required
                                    >{{ $report->description }}</textarea>
                                </div>
                            </div>

                            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                                    Сохранить изменения
                                </button>
                                
                                <a href="/reports" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                    Отмена
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </main>

    </x-app-layout>
</body>

</html>