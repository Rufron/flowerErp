/* public/js/order/order.js
   Renders cart on checkout page and sends order to server.
*/
(function () {
  const CART_KEY = 'flower_cart_v1';
  const ORDERS_KEY = 'flower_orders_v1'; // client-side history backup

  function getCart() {
    try {
      return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    } catch (e) {
      return [];
    }
  }

  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  function saveOrderLocal(orderObj) {
    const arr = JSON.parse(localStorage.getItem(ORDERS_KEY) || '[]');
    arr.push(orderObj);
    localStorage.setItem(ORDERS_KEY, JSON.stringify(arr));
  }

  function formatMoney(n) {
    return `$${Number(n).toFixed(2)}`;
  }

  function renderCart() {
    const cart = getCart();
    const tbody = document.querySelector('[data-order-table]');
    const subtotalEl = document.querySelector('[data-order-subtotal]');
    tbody.innerHTML = '';

    let subtotal = 0;
    cart.forEach((item, i) => {
      const total = Number(item.price) * Number(item.qty);
      subtotal += total;

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="px-2 py-3">${item.name}</td>
        <td class="px-2 py-3">${formatMoney(item.price)}</td>
        <td class="px-2 py-3">
          <input type="number" min="1" value="${item.qty}" data-idx="${i}" class="order-qty w-16 p-1 border rounded"/>
          <button data-remove="${i}" class="ml-2 text-sm text-red-600">Remove</button>
        </td>
        <td class="px-2 py-3">${formatMoney(total)}</td>
      `;
      tbody.appendChild(tr);
    });

    if (subtotalEl) subtotalEl.textContent = formatMoney(subtotal);
  }

  function attachListeners() {
    const tbody = document.querySelector('[data-order-table]');

    tbody.addEventListener('click', function (e) {
      const rem = e.target.closest('[data-remove]');
      if (rem) {
        const idx = Number(rem.getAttribute('data-remove'));
        const cart = getCart();
        cart.splice(idx, 1);
        saveCart(cart);
        renderCart();
      }
    });

    tbody.addEventListener('change', function (e) {
      if (e.target.matches('.order-qty')) {
        const idx = Number(e.target.getAttribute('data-idx'));
        const val = Number(e.target.value) || 1;
        const cart = getCart();
        if (cart[idx]) {
          cart[idx].qty = val;
          saveCart(cart);
          renderCart();
        }
      }
    });

    // Place order
    const placeBtn = document.querySelector('[data-order-place]');
    if (placeBtn) {
      placeBtn.addEventListener('click', async function () {
        const cart = getCart();
        if (!cart.length) {
          alert('Your cart is empty.');
          return;
        }

        // Build payload
        const items = cart.map(ci => ({
          id: ci.id || null,
          name: ci.name,
          price: Number(ci.price),
          qty: Number(ci.qty),
        }));
        const subtotal = items.reduce((s, it) => s + it.price * it.qty, 0);

        // POST to server
        const url = (window.routes && window.routes.placeOrder) ? window.routes.placeOrder : '/checkout';
        try {
          placeBtn.disabled = true;
          placeBtn.textContent = 'Placing order...';

          const res = await fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': window.csrfToken || ''
            },
            body: JSON.stringify({ items, subtotal })
          });

          const data = await res.json();

          if (!res.ok) {
            const msg = data?.message || 'Failed to place order';
            alert(msg);
            placeBtn.disabled = false;
            placeBtn.textContent = 'Place Order';
            return;
          }

          // Save order locally as backup for order-success page
          saveOrderLocal({
            id: data.order_id,
            items,
            subtotal,
            created_at: new Date().toISOString()
          });

          // clear cart
          localStorage.removeItem(CART_KEY);

          // redirect to success page
          const successUrl = (window.routes && window.routes.orderSuccess) ? window.routes.orderSuccess : '/order-success';
          window.location.href = `${successUrl}?orderId=${data.order_id}`;
        } catch (err) {
          console.error(err);
          alert('An error occurred while placing the order.');
          placeBtn.disabled = false;
          placeBtn.textContent = 'Place Order';
        }
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    renderCart();
    attachListeners();
  });
})();
