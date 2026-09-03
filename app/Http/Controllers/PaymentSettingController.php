<?php

namespace App\Http\Controllers;

use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentSettingController extends Controller
{
    public function edit()
    {
        $paymentSetting = PaymentSetting::first();

        if (!$paymentSetting) {
            $paymentSetting = PaymentSetting::create();
        }

        return view('admin.payment-settings.edit', compact('paymentSetting'));
    }

    public function update(Request $request)
    {
        $paymentSetting = PaymentSetting::first();

        if (!$paymentSetting) {
            $paymentSetting = PaymentSetting::create();
        }

        $validated = $request->validate([
            'qris_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bank_name' => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name' => ['required', 'string', 'max:255'],
        ], [
            'qris_image.image' => 'File QRIS harus berupa gambar.',
            'qris_image.mimes' => 'Format QRIS harus JPG, JPEG, PNG, atau WEBP.',
            'qris_image.max' => 'Ukuran gambar maksimal 2 MB.',
            'bank_name.required' => 'Nama bank wajib diisi.',
            'account_number.required' => 'Nomor rekening wajib diisi.',
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
        ]);

        if ($request->hasFile('qris_image')) {
            if ($paymentSetting->qris_image) {
                Storage::disk('public')->delete($paymentSetting->qris_image);
            }

            $validated['qris_image'] = $request->file('qris_image')->store('payments', 'public');
        }

        $paymentSetting->update($validated);

        return redirect()
            ->route('admin.payment-settings.edit')
            ->with('success', 'Pengaturan pembayaran berhasil diperbarui.');
    }
}