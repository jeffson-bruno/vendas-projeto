<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\SaleItem;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['client', 'user', 'paymentMethod'])->orderBy('created_at', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        return view('sales.create', compact('clients', 'products', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Calcular total da venda com base nas parcelas (se informadas), senão pelos itens
            if ($request->has('installments') && count($request->installments) > 0) {
                $total = array_sum(array_column($request->installments, 'amount'));
            } else {
                $total = 0;
                foreach ($request->items as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                }
            }

            // Criar a venda
            $sale = Sale::create([
                'client_id' => $request->client_id,
                'user_id' => Auth::id(),
                'payment_method_id' => $request->payment_method_id,
                'total' => $total,
            ]);

            // Salvar itens da venda
            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            // Salvar parcelas (se existirem)
            if ($request->has('installments')) {
                foreach ($request->installments as $parcel) {
                    Installment::create([
                        'sale_id' => $sale->id,
                        'due_date' => $parcel['due_date'],
                        'amount' => $parcel['amount'],
                        'status' => 'pending',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Venda registrada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao salvar a venda: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['client', 'user', 'paymentMethod', 'saleItems', 'installments']);
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $clients = Client::all();
        $products = Product::all();
        $paymentMethods = PaymentMethod::all();
        $sale->load('saleItems', 'installments');
        return view('sales.edit', compact('sale', 'clients', 'products', 'paymentMethods'));
    }

    public function update(Request $request, Sale $sale)
    {
        DB::beginTransaction();

        try {
            // Deletar itens e parcelas antigas
            $sale->saleItems()->delete();
            $sale->installments()->delete();

            // Calcular novo total com base nas parcelas (se informadas), senão pelos itens
            if ($request->has('installments') && count($request->installments) > 0) {
                $total = array_sum(array_column($request->installments, 'amount'));
            } else {
                $total = 0;
                foreach ($request->items as $item) {
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                }
            }

            // Atualizar venda
            $sale->update([
                'client_id' => $request->client_id,
                'payment_method_id' => $request->payment_method_id,
                'total' => $total,
            ]);

            // Inserir novos itens
            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            // Inserir novas parcelas
            foreach ($request->installments as $parcel) {
                Installment::create([
                    'sale_id' => $sale->id,
                    'due_date' => $parcel['due_date'],
                    'amount' => $parcel['amount'],
                    'status' => 'pending',
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')->with('success', 'Venda atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar a venda: ' . $e->getMessage());
        }
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venda excluída com sucesso!');
    }

    public function generatePdf($id)
    {
        $sale = Sale::with(['client', 'user', 'paymentMethod', 'saleItems', 'installments'])->findOrFail($id);

        $pdf = Pdf::loadView('sales.pdf', compact('sale'));

        return $pdf->download('venda_' . $sale->id . '.pdf');
    }
}
