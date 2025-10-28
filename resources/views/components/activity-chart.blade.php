@props(['data', 'title' => 'Активность'])

<div class="activity-chart bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-900 mb-6">{{ $title }}</h3>
    <div class="h-48 flex items-end justify-between gap-3">
        @foreach($data as $item)
            <div class="flex flex-col items-center flex-1">
                <div class="w-full bg-gray-200 rounded-t-lg overflow-hidden" style="height: 120px;">
                    <div class="bg-indigo-500 w-full rounded-t-lg" 
                         style="height: {{ $data->max('count') > 0 ? ($item->count / $data->max('count')) * 100 : 0 }}%"></div>
                </div>
                <div class="text-sm text-gray-500 mt-3">
                    {{ \Carbon\Carbon::parse($item->date)->format('d.m') }}
                </div>
            </div>
        @endforeach
    </div>
</div>