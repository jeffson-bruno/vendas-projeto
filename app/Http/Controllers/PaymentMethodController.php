<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Mostrar lista de métodos de pagamento.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('payment-methods.index', compact('paymentMethods'));
    }

    /**
     * Mostrar formulário para cadastrar novo método de pagamento.
     */
    public function create()
    {
        return view('payment-methods.create');
    }

    /**
     * Salvar novo método de pagamento.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
        ]);

        return redirect()->route('payment-methods.index')->with('success', 'Método de pagamento cadastrado com sucesso!');
    }

    /**
     * Mostrar formulário de edição.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Atualizar método de pagamento.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
        ]);

        return redirect()->route('payment-methods.index')->with('success', 'Método de pagamento atualizado com sucesso!');
    }

    /**
     * Excluir método de pagamento.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->route('payment-methods.index')->with('success', 'Método de pagamento excluído com sucesso!');
    }
}