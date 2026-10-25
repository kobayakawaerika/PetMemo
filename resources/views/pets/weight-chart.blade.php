<x-layout title="体重グラフ">
    <div class="mx-auto max-w-md px-4 py-4">
        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <h2 class="text-lg font-bold">{{ $pet->name }}の体重グラフ</h2>

            @if (count($chartData) >= 2)
                <div class="mt-4">
                    <canvas id="weightChart"></canvas>
                </div>
            @else
                <p class="mt-4 text-gray-500">グラフは2件以上の記録で表示されます</p>
            @endif

            <a href="{{ route('index', ['pet' => $pet->id]) }}"
                class="mt-6 block text-center text-sm text-gray-500 hover:text-gray-700">
                戻る
            </a>
        </div>
    </div>

    @if (count($chartData) >= 2)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('weightChart'), {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: '体重(kg)',
                        data: @json($chartData),
                        borderColor: '#fb923c',
                        backgroundColor: '#fb923c',
                        tension: 0.3,
                    }],
                },
                options: {
                    scales: {
                        y: { title: { display: true, text: 'kg' } },
                    },
                },
            });
        });
    </script>
    @endif
</x-layout>