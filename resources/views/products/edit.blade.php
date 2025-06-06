

<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Produto</h1>

        <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">Nome</label>
                <input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Preço</label>
                <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar</button>
                <a href="{{ route('products.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
