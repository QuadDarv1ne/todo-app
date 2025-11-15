@extends('layouts.app')

@section('title', 'Мои донаты')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Мои донаты</h1>

    @foreach($stats as $currencyStats)
    <div class="stats-section mb-12">
        <div class="text-xl font-semibold mb-4 mt-8">Статистика для {{ $currencyStats->currency }}</div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Кол-во донатов</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->count, 0, ',', ' ') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Общая сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->total, 2, '.', '') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Средняя сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->average, 6, '.', '') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Мин. сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->min, 2, '.', '') }}</div>
            </div>
            
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-gray-500 text-sm mb-1">Макс. сумма</div>
                <div class="text-2xl font-bold">{{ number_format($currencyStats->max, 2, '.', '') }}</div>
            </div>
        </div>
    </div>
    @endforeach

    @if($stats->isEmpty())
    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-gray-500">У вас пока нет донатов</p>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 mt-8">
        <h2 class="text-xl font-semibold mb-4">Последние донаты</h2>
        @foreach($recentDonations as $donation)
        <div class="border-b border-gray-100 py-4 flex justify-between items-center">
            <div>
                <span class="font-semibold text-blue-500">{{ $donation->currency }}</span>
                <div class="text-gray-500 text-sm">
                    {{ $donation->created_at->format('d.m.Y H:i') }}
                </div>
            </div>
            <div class="text-xl font-semibold">{{ number_format($donation->amount, 2) }}</div>
        </div>
        @endforeach
        
        @if($recentDonations->isEmpty())
        <p class="text-gray-500">Нет донатов для отображения</p>
        @endif
    </div>
</div>
@endsection