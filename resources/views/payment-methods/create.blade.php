
<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Nova Forma de Pagamento</h1>

        <form action="{{ route('payment-methods.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nome</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <a href="{{ route('payment-methods.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
