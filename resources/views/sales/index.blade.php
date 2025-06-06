<x-app-layout>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Vendas</h1>

        <a href="{{ route('sales.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nova Venda
        </a>

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Cliente</th>
                    <th class="border px-4 py-2">Total</th>
                    <th class="border px-4 py-2">Data</th>
                    <th class="border px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sales as $sale)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $sale->id }}</td>
                        <td class="border px-4 py-2">{{ $sale->client->name ?? 'Sem Cliente' }}</td>
                        <td class="border px-4 py-2">R$ {{ number_format($sale->total, 2, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $sale->created_at->format('d/m/Y') }}</td>
                        <td class="border px-4 py-2 space-x-2">

                            <a href="{{ route('sales.show', $sale->id) }}" 
                               class="text-purple-600 hover:underline">
                                Ver
                            </a>

                            |

                            <a href="{{ route('sales.edit', $sale->id) }}" 
                               class="text-blue-600 hover:underline">
                                Editar
                            </a>

                            |

                            <a href="{{ route('sales.pdf', $sale->id) }}" 
                               class="text-green-600 hover:underline" 
                               target="_blank">
                                PDF
                            </a>

                            |

                            <form action="{{ route('sales.destroy', $sale->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Deseja realmente excluir esta venda?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:underline">
                                    Excluir
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center">
                            Nenhuma venda cadastrada.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

