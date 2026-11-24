<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Menyiapkan data halaman, memvalidasi input, dan membentuk hasil simulasi pesanan.
 */
class TopupController extends Controller
{
    private const PACKAGES = [
        '86' => ['diamonds' => 86, 'price' => 20000],
        '172' => ['diamonds' => 172, 'price' => 39000],
        '257' => ['diamonds' => 257, 'price' => 58000],
        '344' => ['diamonds' => 344, 'price' => 77000],
        '514' => ['diamonds' => 514, 'price' => 114000],
        '706' => ['diamonds' => 706, 'price' => 154000],
    ];

    private const PAYMENT_METHODS = [
        'qris' => 'QRIS',
        'ewallet' => 'E-Wallet',
        'bank' => 'Transfer Bank',
    ];

    public function index(): View
    {
        return view('topup.index', [
            'packages' => self::PACKAGES,
            'paymentMethods' => self::PAYMENT_METHODS,
            'order' => session('order'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'player_id' => ['required', 'string', 'max:30'],
            'server_id' => ['required', 'string', 'max:10'],
            'package' => ['required', 'string', Rule::in(array_keys(self::PACKAGES))],
            'payment_method' => ['required', 'string', Rule::in(array_keys(self::PAYMENT_METHODS))],
        ]);

        $package = self::PACKAGES[$validated['package']];

        return redirect()
            ->route('home')
            ->with('order', [
                'player_id' => $validated['player_id'],
                'server_id' => $validated['server_id'],
                'diamonds' => $package['diamonds'],
                'price' => $package['price'],
                'payment_method' => self::PAYMENT_METHODS[$validated['payment_method']],
                'order_number' => 'DEMO-'.strtoupper(bin2hex(random_bytes(3))),
            ]);
    }
}
