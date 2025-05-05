<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserActivationPage extends Component
{
    public $marketplace;
    public $marketplaceOrderId;

    public function submit()
    {
        $this->validate([
            'marketplace' => 'required|in:Shopee,TikTok',
            'marketplaceOrderId' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'marketplace' => $this->marketplace,
            'marketplace_order_id' => $this->marketplaceOrderId,
            'is_paid' => true, // update is_paid menjadi true
        ]);

        session()->flash('message', 'Order ID berhasil dikirim dan akun sudah aktif!');
    }

    public function render()
    {
        return view('livewire.user-activation-page');
    }
}
