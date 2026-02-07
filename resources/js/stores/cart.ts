import { defineStore } from 'pinia';
import { ref, computed, watch } from 'vue';

export interface CartItem {
  id: number;
  name: string;
  price: number;
  quantity: number;
  image: string;
}

const STORAGE_KEY = 'cart_data';
const EXPIRATION_MS = 1000 * 60 * 60; // 1 hora

export const useCartStore = defineStore('cart', () => {
  const items = ref<CartItem[]>([]);
  const expiresAt = ref<number | null>(null);

  // Cargar desde localStorage al iniciar
  const loadFromStorage = () => {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return;

    try {
      const parsed = JSON.parse(raw);
      const now = Date.now();

      if (parsed.expires_at && now < parsed.expires_at) {
        items.value = parsed.items || [];
        expiresAt.value = parsed.expires_at;
      } else {
        // expirado
        clearCart();
      }
    } catch (e) {
      console.error('Error al leer carrito:', e);
      clearCart();
    }
  };

  // Guardar en localStorage con expiración
  const saveToStorage = () => {
    localStorage.setItem(
      STORAGE_KEY,
      JSON.stringify({
        items: items.value,
        expires_at: Date.now() + EXPIRATION_MS,
      })
    );
    expiresAt.value = Date.now() + EXPIRATION_MS;
  };

  const addToCart = (product: Omit<CartItem, 'quantity'>) => {
    const existing = items.value.find((item) => item.id === product.id);
    if (existing) {
      existing.quantity += 1;
    } else {
      items.value.push({ ...product, quantity: 1 });
    }
  };

  const removeFromCart = (productId: number) => {
    items.value = items.value.filter((item) => item.id !== productId);
  };

  const updateQuantity = (productId: number, quantity: number) => {
    const item = items.value.find((item) => item.id === productId);
    if (item) {
      item.quantity = quantity > 0 ? quantity : 1;
    }
  };

  const clearCart = () => {
    items.value = [];
    expiresAt.value = null;
    localStorage.removeItem(STORAGE_KEY);
  };

  const totalItems = computed(() =>
    items.value.reduce((sum, item) => sum + item.quantity, 0)
  );

  const totalPrice = computed(() =>
    items.value.reduce((sum, item) => sum + item.quantity * item.price, 0)
  );

  // Cargar carrito al iniciar
  loadFromStorage();

  // Guardar automáticamente cada vez que cambie el carrito
  watch(items, saveToStorage, { deep: true });

  return {
    items,
    totalItems,
    totalPrice,
    addToCart,
    removeFromCart,
    updateQuantity,
    clearCart,
  };
});
