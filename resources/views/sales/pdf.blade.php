<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Venda #{{ $sale->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h2>Venda #{{ $sale->id }}</h2>
    <p><strong>Cliente:</strong> {{ $sale->client->name ?? 'Não informado' }}</p>
    <p><strong>Vendedor:</strong> {{ $sale->user->name }}</p>
    <p><strong>Forma de Pagamento:</strong> {{ $sale->paymentMethod->name }}</p>
    <p><strong>Data:</strong> {{ $sale->created_at->format('d/m/Y') }}</p>

    <h3>Itens da Venda</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->saleItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Parcelas</h3>
    <table>
        <thead>
            <tr>
                <th>Vencimento</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->installments as $installment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($installment->amount, 2, ',', '.') }}</td>
                    <td>{{ $installment->status == 'paid' ? 'Pago' : 'Pendente' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total da Venda: R$ {{ number_format($sale->total, 2, ',', '.') }}</h2>

</body>
</html>
