<x-app-layout>
    <div class="mx-40">
        <h2 class="text-2xl font-semibold">Charts</h2>
        <livewire:chart-orders />
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-app-layout>
