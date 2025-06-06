<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Nova Venda</h1>

        <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Seção: Itens da venda -->
                <div class="md:col-span-2 bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Itens da Venda</h2>

                    <!-- tabela de produtos aqui -->
                    @include('sales.partials.items')

                    <button type="button" onclick="addItem()" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">
                        + Adicionar Produto
                    </button>
                </div>

                <!-- Seção: Cliente e pagamento -->
                <div class="bg-white p-4 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Cliente e Pagamento</h2>

                    <div class="mb-4">
                        <label class="block">Cliente</label>
                        <select name="client_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">Selecione</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block">Forma de Pagamento</label>
                        <select name="payment_method_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">Selecione</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6 font-bold">
                        Total: R$ <span id="total">0.00</span>
                    </div>
                </div>
            </div>

            <!-- Seção: Parcelas -->
            <div class="mt-6 bg-white p-4 rounded shadow">
                <h2 class="text-xl font-semibold mb-4">Parcelas</h2>

                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium">Quantidade de Parcelas</label>
                        <input type="number" name="parcelas" value="1" min="1" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium">Data da Primeira Parcela</label>
                        <input type="date" name="first_due_date" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <!-- Tabela de parcelas geradas -->
                <div>
                    @include('sales.partials.installments')
                    </div>
                </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded">Salvar Venda</button>
                <a href="{{ route('sales.index') }}" class="ml-4 text-gray-600">Cancelar</a>
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

        document.querySelector('input[name="parcelas"]').addEventListener('change', generateInstallments);
        document.querySelector('input[name="first_due_date"]').addEventListener('change', generateInstallments);

        function generateInstallments() {
            const count = parseInt(document.querySelector('input[name="parcelas"]').value || 1);
            const firstDate = document.querySelector('input[name="first_due_date"]').value;
            const total = parseFloat(document.getElementById('total').innerText || 0);

            const table = document.querySelector('#installments-table tbody');
            table.innerHTML = '';

            if (!firstDate || count <= 0) return;

            const valuePerParcel = (total / count).toFixed(2);
            let currentDate = new Date(firstDate);

            for (let i = 1; i <= count; i++) {
                const dueDate = currentDate.toISOString().split('T')[0];

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border px-4 py-2">${i}</td>
                    <td class="border px-4 py-2">
                        <input type="date" name="installments[${i - 1}][due_date]" class="w-full border rounded" value="${dueDate}" required>
                    </td>
                    <td class="border px-4 py-2">
                        <input type="number" step="0.01" name="installments[${i - 1}][amount]" class="w-full border rounded" value="${valuePerParcel}" required>
                    </td>
                `;
                table.appendChild(row);

                currentDate.setMonth(currentDate.getMonth() + 1);
            }
        }

    </script>
</x-app-layout>


