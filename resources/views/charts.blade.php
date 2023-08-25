<x-app-layout>
    <div class="mx-40">
        <h2 class="text-2xl font-semibold">Charts</h2>
        <div class="my-6">
            <div>Last Year: {{ array_sum($lastYearOrders) }}</div>
            <div>This Year: {{ array_sum($thisYearOrders) }}</div>
        </div>
        <canvas id="myChart"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Last Year Orders',
                    backgroundColor: 'lightgray',
                    data: {{ Js::from($lastYearOrders) }},
                }, {
                    label: 'This Year Orders',
                    backgroundColor: 'lightgreen',
                    data: {{ Js::from($thisYearOrders) }},
                }]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        </script>
    @endpush
</x-app-layout>
