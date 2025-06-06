<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Formas de Pagamento</h1>

        <a href="{{ route('payment-methods.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            + Nova Forma de Pagamento
        </a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nome</th>
                    <th class="border px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentMethods as $method)
                    <tr>
                        <td class="border px-4 py-2">{{ $method->id }}</td>
                        <td class="border px-4 py-2">{{ $method->name }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('payment-methods.edit', $method->id) }}" class="text-blue-500">Editar</a> |
                            <form action="{{ route('payment-methods.destroy', $method->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Deseja excluir?')" class="text-red-500">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
