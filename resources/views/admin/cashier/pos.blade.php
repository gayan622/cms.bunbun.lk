@extends('admin.layouts.admin_layout')

@section('title', 'POS System - BunBun CMS')
@section('content')

<div class="grid gap-6 lg:grid-cols-3" x-data="posSystem()">
    <div class="lg:col-span-2">
        <input type="text" x-model="search" placeholder="Search menu..." class="mb-4 w-full rounded-2xl border p-4 shadow">

        <div class="flex gap-2 mb-6 overflow-x-auto pb-2">
            <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-[#E50914] text-white' : 'bg-white'" class="px-6 py-2 rounded-full font-bold shadow transition">All</button>
            <template x-for="cat in categories" :key="cat.id">
                <button @click="activeCategory = cat.id" :class="activeCategory === cat.id ? 'bg-[#E50914] text-white' : 'bg-white'" class="px-6 py-2 rounded-full font-bold shadow transition" x-text="cat.name"></button>
            </template>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <template x-for="item in filteredMenu" :key="item.id">
    <div class="rounded-3xl bg-white p-4 shadow border hover:border-red-500">
        <h3 class="font-black" x-text="item.name"></h3>
        <p class="text-sm text-gray-500">Rs. <span x-text="item.price"></span></p>

        <p class="text-xs font-bold mt-1" :class="item.stock > 0 ? 'text-green-600' : 'text-red-600'">
            Stock: <span x-text="item.stock"></span>
        </p>

       <button
    @click="addToCart(item)"
    :disabled="item.stock <= 0"
    :class="item.stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-[#E50914] hover:bg-red-700'"
    class="mt-4 w-full rounded-xl p-3 font-bold text-white transition">
    <span x-text="item.stock <= 0 ? 'Out of Stock' : '+ Add'"></span>
</button>
    </div>
</template>
        </div>
    </div>

    <div class="rounded-3xl bg-[#1C1A17] p-6 text-white h-fit">
        <h3 class="mb-5 text-2xl font-black text-yellow-400">Current Bill</h3>

        <div class="space-y-4 mb-6">
            <template x-for="item in cart" :key="item.id">
                <div class="flex justify-between border-b border-white/10 pb-2">
                    <span x-text="item.name + ' x' + item.qty"></span>
                    <span x-text="'Rs. ' + (item.price * item.qty)"></span>
                </div>
            </template>
        </div>

        <div class="space-y-4 border-t border-white/20 pt-4">
            <div class="flex justify-between text-xl font-bold">
                <span>Total:</span>
                <span x-text="'Rs. ' + total.toFixed(2)"></span>
            </div>

            <div class="flex justify-between items-center">
                <span>Paid Amount:</span>
                <input type="number" x-model="paidAmount" class="w-24 text-black rounded p-2 text-right">
            </div>

            <div class="flex justify-between font-black text-lg" :class="balance < 0 ? 'text-red-400' : 'text-green-400'">
                <span>Change:</span>
                <span x-text="'Rs. ' + balance.toFixed(2)"></span>
            </div>

            <select x-model="orderType" class="w-full text-black p-2 rounded">
                <option value="dine_in">Dine In</option>
                <option value="takeaway">Takeaway</option>
            </select>

            <select x-model="paymentMethod" class="w-full text-black p-2 rounded">
                <option value="cash">Cash</option>
                <option value="card">Credit Card</option>
            </select>

            <div class="flex justify-between items-center">

                <input type="text" placeholder="Enter customer name" x-model="customer_name" class="w-full text-black rounded p-2 text-left">
            </div>

            <div class="flex justify-between items-center">

                <input type="text" placeholder="Enter contact number" x-model="phone" class="w-full text-black rounded p-2 text-left">
            </div>
        </div>

        <button @click="processOrder()" class="mt-8 w-full rounded-xl bg-yellow-400 p-4 font-black text-black hover:bg-yellow-500 transition">
            Complete Payment
        </button>
    </div>
</div>
<div id="receipt">
    <center>
        <h2>BunBun Kitchen</h2>
        <small>{{ now()->format('Y-m-d H:i:s') }}</small>
    </center>

    <hr>

    <div id="receipt-items"></div>

    <hr>

    <div style="display:flex;justify-content:space-between;">
        <strong>Total</strong>
        <strong id="receipt-total"></strong>
    </div>

    <div style="display:flex;justify-content:space-between;">
        <span>Paid</span>
        <span id="receipt-paid"></span>
    </div>

    <div style="display:flex;justify-content:space-between;">
        <span>Change</span>
        <span id="receipt-change"></span>
    </div>

    <hr>

    <center>
        Thank You
    </center>
</div>


<style>
#receipt {
    display: none;
}

@media print {

    html,
    body {
        margin: 0 !important;
        padding: 0 !important;
        height: auto !important;
        overflow: visible !important;
    }

    body > * {
        display: none !important;
    }

    #receipt {
        display: block !important;
        position: fixed;
        left: 0;
        top: 0;
        width: 80mm;
        padding: 10px;
        font-family: monospace;
        background: #fff;
        color: #000;
        z-index: 99999;
    }

    #receipt * {
        display: block !important;
    }

    .item-row {
        display: flex !important;
        justify-content: space-between !important;
    }
}
</style>

<script>
function posSystem() {
    return {
        customer_name: '',
        phone: '',
        search: '',
        activeCategory: 'all',
        menu: @json($menuItems),
        categories: @json($categories),
        cart: [],
        orderType: 'dine_in',
        paymentMethod: 'cash',
        paidAmount: 0,
        orderNumber: null,
        isProcessing: false,

        // Robust calculation: Ensure values are treated as numbers
        get total() {
            return this.cart.reduce((s, i) => s + (Number(i.price) * i.qty), 0);
        },

        get balance() {
            return Number(this.paidAmount) - this.total;
        },

   buildReceipt() {

    let displayOrder = this.orderNumber ? this.orderNumber : 'PENDING';

    let html = `
        <center>
            <h2>BunBun Kitchen</h2>
            <p style="font-size: 24px; font-weight: bold;">Order # ${displayOrder}</p>
            <small>${new Date().toLocaleString()}</small>
        </center>
        <hr>
    `;

    this.cart.forEach(item => {

        html += `
            <div class="item-row">
                <span>${item.name} x ${item.qty}</span>
                <span>Rs. ${(Number(item.price) * item.qty).toFixed(2)}</span>
            </div>
        `;

    });

    document.getElementById('receipt-items').innerHTML = html;

    document.getElementById('receipt-total').innerHTML =
        `TOTAL : Rs. ${this.total.toFixed(2)}`;

    document.getElementById('receipt-paid').innerHTML =
        `PAID : Rs. ${Number(this.paidAmount).toFixed(2)}`;

    document.getElementById('receipt-change').innerHTML =
        `CHANGE : Rs. ${this.balance.toFixed(2)}`;
},

printReceipt() {

    const receiptHtml =
        document.getElementById('receipt').innerHTML;

    const printWindow = window.open('', '', 'width=400,height=600');

    printWindow.document.write(`
        <html>
        <head>
            <title>Receipt</title>
            <style>
                body{
                    font-family:monospace;
                    padding:10px;
                    width:80mm;
                }

                .item-row{
                    display:flex;
                    justify-content:space-between;
                    margin-bottom:4px;
                }
            </style>
        </head>
        <body>
            ${receiptHtml}
        </body>
        </html>
    `);

    printWindow.document.close();

    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
},

        get filteredMenu() {
            return this.menu.filter(i => {
                let matchesSearch = i.name.toLowerCase().includes(this.search.toLowerCase());
                let matchesCat = this.activeCategory === 'all' || i.category_id == this.activeCategory;
                return matchesSearch && matchesCat;
            });
        },

       addToCart(item) {
    // 1. Double check stock before doing anything
    if (item.stock <= 0) {
        alert('This item is currently out of stock!');
        return;
    }

    let found = this.cart.find(i => i.id === item.id);

    // 2. Check if adding another quantity would exceed stock
    let currentQty = found ? found.qty : 0;
    if (currentQty >= item.stock) {
        alert('Not enough stock available!');
        return;
    }

    if (found) {
        found.qty++;
    } else {
        this.cart.push({...item, qty: 1});
    }
},

        async processOrder() {
            // 1. Validation
            if (this.cart.length === 0) return alert('Cart is empty!');
            if (Number(this.paidAmount) < this.total) return alert('Insufficient payment!');
            if (this.isProcessing) return; // Prevent double submission

            this.isProcessing = true;

            try {
                // 2. API Submission
                let response = await fetch('/cashier/pos/orders', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: this.cart,
                        total: this.total,
                        type: this.orderType,
                        payment_method: this.paymentMethod,
                        customer_name: this.customer_name,
                        phone: this.phone,
                        paid: this.paidAmount,
                        payment_status: (Number(this.paidAmount) >= this.total) ? 'paid' : 'pending',
                    })
                });

                const data = await response.json();
console.log('data:', data);
                if (response.ok) {
                    this.orderNumber = data.order_number;

                     this.buildReceipt();

    await new Promise(resolve => setTimeout(resolve, 500));
//console.log('Cart:', this.cart);
//console.log(document.getElementById('receipt').innerHTML);
    //window.print();
                    this.printReceipt();
    window.onafterprint = () => {
        this.resetSystem();
    };

    this.resetSystem();
                } else {
                    alert('Error: ' + (data.message || 'Unknown server error'));
            console.error('Server Error:', data);
                }
            } catch (error) {
                //console.error(error);
                console.error('Fetch Error:', error);
                if (error.response) {
                    console.error('Server Data:', await error.data || 'No response data');
                }
               alert('Failed to place order. Check the browser console (F12) for the exact error.');
            } finally {
                this.isProcessing = false;
            }
        },

        // 3. Clean Reset Function
        resetSystem() {
            this.cart = [];
            this.paidAmount = 0;
            this.orderType = 'dine_in';
            this.paymentMethod = 'cash';
            this.search = '';
            this.activeCategory = 'all';
            this.customer_name = '';
            this.phone = '';
            this.orderNumber = null;
        }
    }
}
</script>
@endsection
