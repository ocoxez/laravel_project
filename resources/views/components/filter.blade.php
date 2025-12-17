<div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
    <div class="flex flex-col lg:flex-row gap-6 justify-between items-start lg:items-center">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Сортировка</span>
            <div class="flex gap-2">
                <a href="{{ route('report.index', ['sort' => 'desc', 'status' => $status]) }}" 
                   class="px-4 py-2 text-sm rounded-lg border border-transparent {{ $sort == 'desc' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }} transition-colors">
                    Сначала новые
                </a>
                <a href="{{ route('report.index', ['sort' => 'asc', 'status' => $status]) }}" 
                   class="px-4 py-2 text-sm rounded-lg border border-transparent {{ $sort == 'asc' ? 'bg-slate-100 text-slate-900 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }} transition-colors">
                    Сначала старые
                </a>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto overflow-x-auto">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Статус</span>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('report.index', ['sort' => $sort]) }}"
                   class="px-4 py-2 text-sm rounded-full border {{ !$status ? 'bg-blue-50 border-blue-200 text-blue-700 font-medium' : 'border-gray-200 text-gray-600 hover:border-gray-300 hover:bg-gray-50' }} transition-all">
                    Все
                </a>
                @foreach($statuses as $statusItem)
                    <a href="{{ route('report.index', ['sort' => $sort, 'status' => $statusItem->id])}}" 
                       class="px-4 py-2 text-sm rounded-full border whitespace-nowrap transition-all
                       {{ $status == $statusItem->id 
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