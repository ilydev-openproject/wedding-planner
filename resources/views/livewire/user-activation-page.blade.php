<div>
    <div>
        {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    </div>
    <div class="max-w-lg mx-auto py-12 px-6">
        <div class="bg-white shadow-md rounded-lg p-8 space-y-6">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">🎟️ Aktivasi Akun</h1>
                <p class="text-gray-600 text-sm">Masukkan Order ID dari Shopee atau TikTok untuk mengaktifkan akunmu.</p>
            </div>

            @if (session()->has('message'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center">
                {{ session('message') }}
            </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Marketplace</label>
                    <select wire:model="marketplace" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700">
                        <option value="">-- Pilih Marketplace --</option>
                        <option value="Shopee">Shopee</option>
                        <option value="TikTok">TikTok</option>
                    </select>
                    @error('marketplace') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Order ID</label>
                    <input type="text" wire:model="marketplaceOrderId" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-gray-700" placeholder="Contoh: 230412SHO1234">
                    @error('marketplaceOrderId') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        Kirim & Aktivasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>