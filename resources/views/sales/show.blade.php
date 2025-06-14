<x-app-layout>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10"> {{-- Aumenta a largura e centraliza melhor --}}

                {{-- TÍTULO CENTRALIZADO --}}
                <div class="text-center mb-3">
                    <h2>Detalhes da Venda #{{ $sale->id }}</h2>
                    <a href="#" class="btn btn-primary mt-2 px-4 py-2 rounded hover:bg-blue-700 transition duration-300 btn-print" onclick="window.print();">
                        Imprimir PDF
                    </a>
                </div>

                {{-- INFORMAÇÕES DA VENDA --}}
                <div class="card mb-4 shadow">
                    <div class="card-header bg-primary text-dark text-center fw-bold">Informações da Venda</div>
                    <div class="card-body">
                        <p><strong>Cliente:</strong> {{ $sale->client->name }}</p>
                        <p><strong>Usuário Responsável:</strong> {{ $sale->user->name }}</p>
                        <p><strong>Forma de Pagamento:</strong> {{ $sale->paymentMethod->name }}</p>
                        <p><strong>Total da Venda:</strong> R$ {{ number_format($sale->total, 2, ',', '.') }}</p>
                    </div>
                </div>

                {{-- ITENS DA VENDA --}}
                <div class="card mb-4 shadow">
                    <div class="card-header bg-secondary text-dark text-center fw-bold">Itens da Venda</div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">Produto</th>
                                    <th class="px-4 py-3">Quantidade</th>
                                    <th class="px-4 py-3">Preço Unitário</th>
                                    <th class="px-4 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->saleItems as $item)
                                    <tr>
                                        <td class="px-4 py-3">{{ $item->product->name }}</td>
                                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                                        <td class="px-4 py-3">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3">R$ {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PARCELAS --}}
                <div class="card mb-4 shadow">
                    <div class="card-header bg-info text-dark text-center fw-bold">Parcelas</div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Valor</th>
                                    <th class="px-4 py-3">Data de Vencimento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->installments as $index => $installment)
                                    @php
                                        $vencida = \Carbon\Carbon::parse($installment->due_date)->isPast();
                                    @endphp
                                    <tr style="background-color: {{ $vencida ? '#ffe5e5' : '#e5ffe5' }}">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BOTÃO VOLTAR --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded">Voltar</a>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
