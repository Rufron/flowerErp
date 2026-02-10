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
    updateCartCount(); // Update count whenever cart changes
  }

  function getCartCount() {
    const cart = getCart();
    return cart.reduce((total, item) => total + (Number(item.qty) || 0), 0);
  }

  function updateCartCount() {
    const count = getCartCount();
    const cartCountElements = document.querySelectorAll('.cart-count, #cart-count');
    
    cartCountElements.forEach(element => {
      element.textContent = count;
      
      // Hide if count is 0
      if (count === 0) {
        element.classList.add('hidden');
      } else {
        element.classList.remove('hidden');
      }
    });
    
    // Also update any other elements that might show cart count
    document.querySelectorAll('[data-cart-count]').forEach(el => {
      el.textContent = count;
    });
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
    
    // Show notification
    showNotification(item.name + ' added to cart!');
  }
  
  function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
      notification.remove();
    }, 3000);
  }

  // Initialize cart count on page load
  document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
  });

  document.addEventListener('click', function (e) {
    // Handle original add-to-cart buttons
    const btn = e.target.closest('.add-to-cart');
    if (btn) {
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
      return;
    }
    
    // Handle new detail page buttons
    const detailBtn = e.target.closest('.add-to-cart-detail');
    if (detailBtn) {
      const id = detailBtn.dataset.id || null;
      const name = detailBtn.dataset.name || 'Item';
      const price = parseFloat(detailBtn.dataset.price || 0) || 0;
      const qty = parseInt(detailBtn.dataset.qty || 1, 10) || 1;

      addToCart({ id, name, price, qty });
      return;
    }
    
    // Handle buy now button
    const buyNowBtn = e.target.closest('.buy-now-btn');
    if (buyNowBtn) {
      const id = buyNowBtn.dataset.id || null;
      const name = buyNowBtn.dataset.name || 'Item';
      const price = parseFloat(buyNowBtn.dataset.price || 0) || 0;
      const qty = parseInt(buyNowBtn.dataset.qty || 1, 10) || 1;

      addToCart({ id, name, price, qty });
      
      // redirect to checkout
      if (window.routes && window.routes.checkout) {
        window.location.href = window.routes.checkout;
      } else {
        window.location.href = '/checkout';
      }
      return;
    }
    
    // Handle quick add buttons on dashboard
    const quickBtn = e.target.closest('.add-to-cart-quick');
    if (quickBtn) {
      const id = quickBtn.dataset.id || null;
      const name = quickBtn.dataset.name || 'Item';
      const price = parseFloat(quickBtn.dataset.price || 0) || 0;
      const qty = parseInt(quickBtn.dataset.qty || 1, 10) || 1;

      addToCart({ id, name, price, qty });
      return;
    }
  });
})();