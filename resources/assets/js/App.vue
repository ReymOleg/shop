<template>
  <div id="parent" class="wrapper">
    <div id="content" v-bind:class="mainClasses">
      <header class="container-fluid">
        <div class="row top-header">
          <div class="header-logo col-xs-4">
            <router-link to="/">LOGO</router-link>
          </div>
          <div class="header-center col-xs-4">
            <search></search>
          </div>
          <div class="header-right col-xs-4">
            <div class="row">
              <div class="col-xs-6">
                <i class="fa fa-user" aria-hidden="true"></i> Войти
              </div>
              <div class="col-xs-6 pointer">
                <div @click="cartToggle()">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина (0)
                </div>
              </div>
            </div>
          </div>
        </div>
        <nav class="container-fluid center">
          <router-link to="/">Home</router-link>
          <router-link to="/brands">Brands</router-link>
          <router-link to="/contacts">Contacts</router-link>
        </nav>
      </header>
      <main class="container-fluid">
        <transition name="fade" mode="out-in">
          <router-view :key="$route.path" class="container-fluid"></router-view>
        </transition>
      </main>
      <cart></cart>
    </div>
  </div>
</template>

<script>
import Search from './components/Search.vue'
import Cart from './components/Cart.vue'

export default {
  data() {
    return {
      mainClasses: {
        'cart-opened': false,
      }
    }
  },
  methods: {
    cartToggle() {
      this.mainClasses['cart-opened'] = !this.mainClasses['cart-opened']
    }
  },
  name: 'app',
  components: { Search, Cart }
}
</script>
