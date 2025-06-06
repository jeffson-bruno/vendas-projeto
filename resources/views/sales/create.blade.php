<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Nova Venda</h1>

        <form action="{{ route('sales.store') }}" method="POST" id="sale-form" class="space-y-4">
            @csrf

            <div>
                <label class="block">Cliente</label>
                <select name="client_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Selecione</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block">Forma de Pagamento</label>
                <select name="payment_method_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Selecione</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}">{{ $method->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <h2 class="text-xl font-bold mb-2">Itens da Venda</h2>
                <table class="table-auto w-full border" id="items-table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Produto</th>
                            <th class="border px-4 py-2">Quantidade</th>
                            <th class="border px-4 py-2">Preço</th>
                            <th class="border px-4 py-2">Subtotal</th>
                            <th class="border px-4 py-2">Ação</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <button type="button" onclick="addItem()" class="bg-green-500 text-white px-3 py-1 rounded mt-2">
                    + Adicionar Produto
                </button>
            </div>

            <div>
                <label class="block">Quantidade de Parcelas</label>
                <input type="number" name="parcelas" value="1" min="1" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block">Data da Primeira Parcela</label>
                <input type="date" name="first_due_date" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mt-4">
                <h2 class="text-xl font-bold">Total da Venda: R$ <span id="total">0.00</span></h2>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar Venda</button>
                <a href="{{ route('sales.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        const products = @json($products);
        let itemIndex = 0;

        function addItem() {
            const table = document.querySelector('#items-table tbody');
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="border px-2 py-1">
                    <select name="items[${itemIndex}][product_id]" class="w-full border rounded">
                        <option value="">Selecione</option>
                        ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                    </select>
                </td>
                <td class="border px-2 py-1">
                    <input type="number" name="items[${itemIndex}][quantity]" class="w-full border rounded" value="1" min="1" onchange="calculateTotal()">
                </td>
                <td class="border px-2 py-1">
                    <input type="number" step="0.01" name="items[${itemIndex}][price]" class="w-full border rounded" value="0" onchange="calculateTotal()">
                </td>
                <td class="border px-2 py-1 subtotal">R$ 0.00</td>
                <td class="border px-2 py-1">
                    <button type="button" onclick="removeItem(this)" class="text-red-500">Remover</button>
                </td>
            `;
            table.appendChild(row);
            itemIndex++;
        }

        function removeItem(button) {
            button.closest('tr').remove();
            calculateTotal();
        }

        function calculateTotal() {
            const rows = document.querySelectorAll('#items-table tbody tr');
            let total = 0;
            rows.forEach(row => {
                const qty = row.querySelector('input[name*="[quantity]"]').value;
                const price = row.querySelector('input[name*="[price]"]').value;
                const subtotal = qty * price;
                row.querySelector('.subtotal').innerText = `R$ ${subtotal.toFixed(2)}`;
                total += subtotal;
            });
            document.getElementById('total').innerText = total.toFixed(2);
        }
    </script>
</x-app-layout>


