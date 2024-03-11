<template>
    <div class="cart-page">
        <div class="cart-items-section">
            <h2 class="empty-cart">Your Cart</h2>
            <div class="print-offer-btn" v-if="cartItems.length !== 0">
                <button @click="printOffer" class="cart-btn btn btn-primary">Print Offer</button>
            </div>
            <div v-if="cartItems.length === 0" class="empty-cart">
                Your cart is currently empty.
            </div>

            <div v-else class="cart-items">
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th> </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in cartItems" :key="item.productId">
                        <td>
                            <div class="product-info">
                                <img :src="item.image" alt="item.name" class="product-thumbnail">
                                <div>
                                    <h3>{{ item.name }}</h3>
                                    <p v-if="item.manufacturer">by {{ item.manufacturer.name }}</p>
                                    <p style="font-size: 10px">SKU: {{ item.sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td>€{{ item.special_price || item.price }}</td>
                        <td>
                            <button class="quantity-buttons" @click="handleDecreaseQuantity(item.productId)" :disabled="item.quantity <= 1">-</button>
                            <input class="quantity-input" type="number" v-model.number="item.quantity" @change="handleQuantityChange(item.productId, item.quantity)" min="1">
                            <button class="quantity-buttons" @click="handleIncreaseQuantity(item.productId)">+</button>
                        </td>

                        <td>
                            <button @click="handleRemoveProduct(item.productId)" class="cart-btn btn btn-primary">Remove</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="checkout-section">
            <h3 style="text-align: center">Order Summary</h3>
            <table class="checkout-table">
                <tbody>
                <tr>
                    <td>Subtotal:</td>
                    <td class="txt-align-right">€{{ calculateSubtotal() }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td class="txt-align-right">€{{ shippingCost }}</td>
                </tr>
                <tr class="discount-section">
                    <td class="discount-label">Discount Code:</td>
                    <td>
                        <input type="text" class="coupon-input" placeholder="Enter coupon code" v-model="couponCode" @input="calculateTotal">
                    </td>
                </tr>
                <tr v-if="discountAmount > 0" class="discount-row">
                    <td>Discount:</td>
                    <td class="txt-align-right">-€{{ discountAmount.toFixed(2) }}</td>
                </tr>
                <tr class="total">
                    <td>Total:</td>
                    <td class="txt-align-right">€{{ calculateTotal() }}</td>
                </tr>
                </tbody>
            </table>
            <div class="button-wrapper">
                <button class="cart-btn btn btn-primary">Proceed to Checkout</button>
            </div>
        </div>
    </div>

    <div class="print-section">
        <h2 class="print-offer-heading">Order/Offer Summary</h2>
        <table>
            <thead>
            <tr>
                <th>Products</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in cartItems" :key="item.productId">
                <td>{{ item.name }}</td>
                <td>€{{ item.special_price || item.price }}</td>
                <td>{{ item.quantity }}</td>
                <td>€{{ (item.special_price || item.price) * item.quantity }}</td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3"><strong>Subtotal:</strong></td>
                <td class="amount">€{{ calculateSubtotal() }}</td>
            </tr>
            <tr v-if="discountAmount > 0">
                <td colspan="3"><strong>Discount:</strong></td>
                <td colspan="amount">-€{{ discountAmount.toFixed(2) }}</td>
            </tr>
            <tr>
                <td colspan="3"><strong>Total:</strong></td>
                <td class="amount">€{{ calculateTotal() }}</td>
            </tr>
            </tfoot>
        </table>
    </div>


</template>


<script>
import { mapState } from 'vuex';

export default {
    data() {
        return {
            shippingCost: 0,
            couponCode: '',
            discountAmount: 0,
        }
    },
    methods: {

        handleIncreaseQuantity(product_id) {
            console.log(JSON.parse(JSON.stringify(this.cartItems)));
            this.$store.dispatch('increaseQuantity', {
                productId: product_id,
                quantity: 1
            });
        },

        handleDecreaseQuantity(product_id) {
            this.$store.dispatch('decreaseQuantity', {
                productId: product_id,
            });
        },

        handleRemoveProduct(productId) {
            this.$store.dispatch('removeProduct', { productId });
        },

        calculateSubtotal() {
            const subtotal = this.cartItems.reduce((total, item) => {
                return total + (item.quantity * (item.special_price || item.price));
            }, 0);
            return subtotal.toFixed(2);
        },

        calculateTotal() {
            const total = parseFloat(this.calculateSubtotal()) + this.shippingCost - this.applyCoupon();
            return total.toFixed(2);
        },

        applyCoupon() {
            let discount = 0;

            if (this.couponCode === 'DISCOUNT10') {
                discount = parseFloat(this.calculateSubtotal()) * 0.1; // 10% discount
            }

            this.discountAmount = discount; // Update the discountAmount
            return discount.toFixed(2);
        },

        handleQuantityChange(productId, quantity) {
            if (quantity > 0) {
                this.$store.dispatch('updateQuantity', { productId, quantity });
            }
        },

        printOffer() {
            const headerElement = document.querySelector('header');
            if (headerElement) {
                headerElement.classList.add('hidden');
            }
            document.body.classList.add('print');
            window.print();
            document.body.classList.remove('print');
            if (headerElement) {
                headerElement.classList.remove('hidden');
            }
        }
    },
    mounted() {
        this.$store.dispatch('fetchCartItems');

    },
    computed: {
        ...mapState(['cartItems'])

    }


}
</script>

<style>
.cart-page {
    display: flex;
}

.cart-items-section, .checkout-section {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 10px;
    border-radius: 10px;
    background-color: #f5f5f5;
}

.cart-items-section {
    flex: 7;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th, .cart-table td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.cart-table th {
    font-weight: bold;
}

.product-thumbnail {
    width: 80px;
    height: 80px;
    margin-right: 10px;
}

.checkout-section {
    flex: 3;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #f5f5f5;
}

.checkout-table {
    width: 100%;
    border-collapse: collapse;
}

.checkout-table td {
    padding: 15px 10px;
}

.amount-section td {
    border-bottom: 1px solid #ddd;
}

.total td {
    font-weight: bold;
}

.coupon-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 15px;
    background-color: white;
}

.checkout-section {
    margin-bottom: 30px;
}

.button-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
}

.discount-section {
    border-bottom: 1px solid #ddd;
}

.discount-label {
    font-weight: bold;
}

.coupon-input {
    width: 100%;
    padding: 15px; /* Increase height */
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: white;
}

.empty-cart{
    text-align: center;
}


.quantity-input {
    width: 80px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin: 0 5px;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.quantity-buttons {
    cursor: pointer;
    transition: all 0.2s ease;

    width: 40px;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;

    background-color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.quantity-buttons:hover {
    background-color: #f0f0f0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

.quantity-buttons:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.txt-align-right
{
    text-align: right;
    margin-right: 5px;
}

.print-section table {
    width: 100%;
    border-collapse: collapse;
}

.print-section th, .print-section td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.print-section td {
    word-wrap: break-word;
    max-width: 200px;
}

.print-section th {
    text-align: center;
}

.print-section .amount, .print-section th:last-child {
    text-align: right;
}

.print-offer-heading{
    text-align: center !important;
    margin-bottom: 90px;
}

.print-section{
    visibility: hidden;
}

.print-offer-btn {
    text-align: right;
    margin-bottom: 10px;
}


@media print {
    body * {
        visibility: hidden;
    }



    .print-section {
        position: absolute;
        left: 0;
        top: 0;
    }

    .print-section table {
        font-size: 12px;
    }

    .print-section th, .print-section td {
        border: 1px solid black;
    }

    .print-section .amount {
        text-align: right;
    }
}

@media print {

    body * {
        visibility: hidden !important;
    }

    .top-bar .mid-block .nav-block {
        visibility: hidden !important;
        display: none !important;
    }

    .print-section, .print-section * {
        visibility: visible !important;
    }

    .print-section {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
    }
}


</style>
