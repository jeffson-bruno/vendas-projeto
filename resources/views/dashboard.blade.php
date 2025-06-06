<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Card Total de Vendas -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Total de Vendas</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $totalVendas }}</p>
            </div>

            <!-- Card Total de Produtos -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Total de Produtos</h2>
                <p class="text-3xl font-bold text-green-600">{{ $totalProdutos }}</p>
            </div>

            <!-- Card Faturamento Total -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Faturamento Total</h2>
                <p class="text-3xl font-bold text-yellow-600">
                    R$ {{ number_format($faturamento, 2, ',', '.') }}
                </p>
            </div>

        </div>
    </div>
</x-app-layout>


