

<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Cliente</h1>

        <form action="{{ route('clients.update', $client->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">Nome</label>
                <input type="text" name="name" value="{{ $client->name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Email</label>
                <input type="email" name="email" value="{{ $client->email }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block">Telefone</label>
                <input type="text" name="phone" value="{{ $client->phone }}" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar</button>
                <a href="{{ route('clients.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
