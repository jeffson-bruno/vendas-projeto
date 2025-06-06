

<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Novo Cliente</h1>

        <form action="{{ route('clients.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nome</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Telefone</label>
                <input type="text" name="phone" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                <a href="{{ route('clients.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
