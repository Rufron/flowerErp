
  // --- Cart Manager (front-end only, localStorage) ---
  const CART_KEY = 'flower_cart_v1';

  const cartStore = {
    load() {
      try { return JSON.parse(localStorage.getItem(CART_KEY) || '[]'); }
      catch { return []; }
    },
    save(cart) {
      localStorage.setItem(CART_KEY, JSON.stringify(cart));
    },
    add(item) {
      const cart = this.load();
      const idx = cart.findIndex(p => String(p.id) === String(item.id));
      if (idx > -1) {
        cart[idx].qty += item.qty || 1;
      } else {
        cart.push({ id: item.id, name: item.name, price: Number(item.price), image: item.image || '', qty: item.qty || 1 });
      }
      this.save(cart);
      return cart;
    },
    remove(id) {
      const cart = this.load().filter(p => String(p.id) !== String(id));
      this.save(cart);
      return cart;
    },
    updateQty(id, qty) {
      const cart = this.load();
      const idx = cart.findIndex(p => String(p.id) === String(id));
      if (idx > -1) {
        cart[idx].qty = Math.max(1, Number(qty) || 1);
        this.save(cart);
      }
      return cart;
    },
    clear() {
      this.save([]);
      return [];
    },
    totals() {
      const cart = this.load();
      const subtotal = cart.reduce((sum, p) => sum + p.price * p.qty, 0);
      return { count: cart.reduce((n, p) => n + p.qty, 0), subtotal };
    }
  };

  // --- UI helpers ---
  function formatMoney(n) {
    return '$' + (Number(n || 0)).toFixed(2);
  }

  function updateCartCountBadge() {
    const el = document.getElementById('cart-count');
    if (!el) return;
    el.textContent = cartStore.totals().count;
  }

  // Renders the small "Your Cart" widget (the list on your dashboard)
  function renderCartWidget() {
    const list = document.querySelector('[data-cart-list]');
    const checkoutBtn = document.querySelector('[data-cart-checkout]');
    if (!list) return;

    const cart = cartStore.load();
    list.innerHTML = '';

    if (cart.length === 0) {
      list.innerHTML = '<li class="p-3 text-gray-500 bg-gray-50 rounded-lg border">Your cart is empty</li>';
      if (checkoutBtn) checkoutBtn.classList.add('pointer-events-none', 'opacity-60');
      updateCartCountBadge();
      return;
    }

    cart.forEach(item => {
      const li = document.createElement('li');
      li.className = 'p-3 bg-gray-50 rounded-lg border flex items-center justify-between';
      li.innerHTML = `
        <div class="flex items-center gap-3">
          ${item.image ? `<img src="${item.image}" class="w-10 h-10 rounded object-cover" alt="${item.name}">` : ''}
          <span class="text-gray-700">${item.qty}× ${item.name}</span>
        </div>
        <div class="flex items-center gap-2">
          <span class="font-medium">${formatMoney(item.price * item.qty)}</span>
          <button class="text-red-500 hover:underline text-sm" data-remove="${item.id}">Remove</button>
        </div>
      `;
      list.appendChild(li);
    });

    // Remove handlers
    list.querySelectorAll('[data-remove]').forEach(btn => {
      btn.addEventListener('click', () => {
        cartStore.remove(btn.getAttribute('data-remove'));
        renderCartWidget();
        updateCartCountBadge();
      });
    });

    if (checkoutBtn) checkoutBtn.classList.remove('pointer-events-none', 'opacity-60');
    updateCartCountBadge();
  }

  // --- Event: Add to Cart clicks ---
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.js-add-to-cart');
    if (!btn) return;
    e.preventDefault();

    const item = {
      id: btn.dataset.id,
      name: btn.dataset.name,
      price: btn.dataset.price,
      image: btn.dataset.image,
      qty: 1
    };

    cartStore.add(item);
    updateCartCountBadge();
    renderCartWidget();

    // Optional: tiny toast
    if (!document.getElementById('toast')) {
      const toast = document.createElement('div');
      toast.id = 'toast';
      toast.className = 'fixed bottom-4 right-4 bg-pink-600 text-white px-4 py-2 rounded-lg shadow-lg';
      toast.textContent = `${item.name} added to cart`;
      document.body.appendChild(toast);
      setTimeout(() => toast.remove(), 1600);
    }
  });




  // Init on load
  window.addEventListener('DOMContentLoaded', () => {
    updateCartCountBadge();
    renderCartWidget();
  });



