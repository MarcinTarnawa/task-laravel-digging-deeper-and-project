<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Wyswietlanie
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    // Edycja - widok
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    // Aktualizacja
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required','string','min:2'],
            'lastName' => ['required','string','min:2'],
            'email' => ['required','string','email','min:2'],
            'address' => ['required','string','min:2'],
        ]);

        Customer::whereId($id)->update($validated);
        return redirect('/customer')->with('success', 'Dane klienta zaktualizowane');
    }

    // Usuwanie
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Klient usunięty');
    }

    // Dodawanie
    public function store()
    {
        $validated = request()->validate([
            'name'     => ['required', 'string', 'min:2', 'max:50'],
            'lastName' => ['required', 'string', 'min:2', 'max:50'],
            'address'  => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:50'],
        ]);

        Customer::create($validated);
        return redirect('customer')->with('success', 'Klient został dodany');
    }
}
