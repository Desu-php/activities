@extends('layouts.app')

@section('title', 'Список активностей')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">Список активностей</h1>

        @foreach($activities as $activity)
            <div class="p-4 mb-6 border rounded-lg shadow-sm bg-white">
                <h2 class="text-xl font-semibold">{{ $activity->name }}</h2>
                <p class="text-gray-600">{{ $activity->short_description }}</p>

                <div class="mt-2 text-sm text-gray-500">
                    <strong>Тип:</strong> {{ $activity->activityType->name ?? '—' }}<br>
                    <strong>Участник:</strong> {{ $activity->participant->name ?? '—' }}<br>
                    <strong>Описание:</strong> {{ $activity->description }}<br>
                    <strong>Ссылка на регистрацию:</strong>
                    <a href="{{ $activity->registration_link }}" class="text-blue-500 underline" target="_blank">
                        {{ $activity->registration_link }}
                    </a><br>
                    <strong>Время активности:</strong> {{ json_encode($activity->activity_times) }}
                </div>
                <div id="map-{{ $activity->id }}" class="h-64 mt-4 rounded-lg"></div>
            </div>

            @push('scripts')
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const map{{ $activity->id }} = L.map('map-{{ $activity->id }}').setView([55, 37], 2);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors'
                        }).addTo(map{{ $activity->id }});

                        try {
                            let geoJson = {!! json_encode(json_decode($activity->area->toJson())) !!};
                            let polygon = L.geoJSON(geoJson).addTo(map{{ $activity->id }});
                            map{{ $activity->id }}.fitBounds(polygon.getBounds());
                        } catch (e) {
                            console.error("Ошибка при отрисовке полигона активности {{ $activity->id }}", e);
                        }
                    });
                </script>
            @endpush
        @endforeach

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
