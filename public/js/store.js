/* public/js/store.js
   Handles Add to Cart and redirect to checkout
*/
(function () {
  const CART_KEY = 'flower_cart_v1';

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

  function addToCart(item) {
    const cart = getCart();
    // find by id if present; otherwise use name+price fallback
    const idx = cart.findIndex(ci => (ci.id && item.id && String(ci.id) === String(item.id)) || (ci.name === item.name && ci.price === item.price));
    if (idx > -1) {
      cart[idx].qty = Number(cart[idx].qty) + Number(item.qty);
    } else {
      cart.push(item);
    }
    saveCart(cart);
  }

  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.add-to-cart');
    if (!btn) return;

    const id = btn.dataset.id || null;
    const name = btn.dataset.name || btn.dataset.title || 'Item';
    const price = parseFloat(btn.dataset.price || btn.dataset.amount || 0) || 0;
    const qty = parseInt(btn.dataset.qty || 1, 10) || 1;

    addToCart({ id, name, price, qty });
    // redirect to checkout
    if (window.routes && window.routes.checkout) {
      window.location.href = window.routes.checkout;
    } else {
      // fallback: open /checkout
      window.location.href = '/checkout';
    }
  });
})();
