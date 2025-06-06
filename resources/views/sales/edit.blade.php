<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Editar Venda</h1>

        <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="sale-form" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block">Cliente</label>
                <select name="client_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Selecione</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $sale->client_id == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block">Forma de Pagamento</label>
                <select name="payment_method_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Selecione</option>
                    @foreach($paymentMethods as $method)
                        <option value="{{ $method->id }}" {{ $sale->payment_method_id == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
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
                    <tbody>
                        @foreach($sale->saleItems as $index => $item)
                            <tr>
                                <td class="border px-2 py-1">
                                    <select name="items[{{ $index }}][product_id]" class="w-full border rounded" onchange="updatePrice(this, {{ $index }})">
                                        <option value="">Selecione</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="number" name="items[{{ $index }}][quantity]" class="w-full border rounded"
                                           value="{{ $item->quantity }}" min="1" onchange="calculateTotal()">
                                </td>
                                <td class="border px-2 py-1">
                                    <input type="number" step="0.01" name="items[{{ $index }}][price]" class="w-full border rounded"
                                           value="{{ $item->price }}" onchange="calculateTotal()">
                                </td>
                                <td class="border px-2 py-1 subtotal">R$ {{ number_format($item->quantity * $item->price, 2, ',', '.') }}</td>
                                <td class="border px-2 py-1">
                                    <button type="button" onclick="removeItem(this)" class="text-red-500">Remover</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" onclick="addItem()" class="bg-green-500 text-white px-3 py-1 rounded mt-2">
                    + Adicionar Produto
                </button>
            </div>

            <div>
                <label class="block">Quantidade de Parcelas</label>
                <input type="number" name="parcelas" value="{{ count($sale->installments) }}" min="1" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block">Data da Primeira Parcela</label>
                <input type="date" name="first_due_date" value="{{ $sale->installments->first()->due_date ?? '' }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mt-4">
                <h2 class="text-xl font-bold">Total da Venda: R$ <span id="total">0.00</span></h2>
            </div>

            <div>
                <h2 class="text-xl font-bold mt-6 mb-2">Parcelas</h2>
                <table class="table-auto w-full border" id="installments-table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Parcela</th>
                            <th class="border px-4 py-2">Data de Vencimento</th>
                            <th class="border px-4 py-2">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->installments as $i => $parcel)
                            <tr>
                                <td class="border px-4 py-2">{{ $i + 1 }}</td>
                                <td class="border px-4 py-2">
                                    <input type="date" name="installments[{{ $i }}][due_date]" value="{{ $parcel->due_date }}" class="w-full border rounded" required>
                                </td>
                                <td class="border px-4 py-2">
                                    <input type="number" step="0.01" name="installments[{{ $i }}][amount]" value="{{ $parcel->amount }}" class="w-full border rounded" required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Atualizar Venda</button>
                <a href="{{ route('sales.index') }}" class="ml-2 text-gray-600">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        const products = @json($products);
        let itemIndex = {{ count($sale->saleItems) }};

        function addItem() {
            const table = document.querySelector('#items-table tbody');
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="border px-2 py-1">
                    <select name="items[${itemIndex}][product_id]" class="w-full border rounded" onchange="updatePrice(this, ${itemIndex})">
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

        function updatePrice(select, index) {
            const productId = select.value;
            const product = products.find(p => p.id == productId);
            if (product) {
                const priceInput = document.querySelector(`input[name="items[${index}][price]"]`);
                if (priceInput) {
                    priceInput.value = product.price;
                    calculateTotal();
                }
            }
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
                row.querySelector('.subtotal').innerText = `R$ ${parseFloat(subtotal).toFixed(2)}`;
                total += subtotal;
            });
            document.getElementById('total').innerText = total.toFixed(2);
        }

        calculateTotal();
    </script>
</x-app-layout>
