<template>
  <div id="parent" class="wrapper">
    <div id="content" :class="classes.mainClasses">
      <!-- REMOVE CLICK CHECKAUTH() -->
      <header class="container-fluid" @click="checkAuth()">
        <cart></cart>
        <div v-if="!isAuth" class="login-modal-block" :class="classes.loginModalClasses">
          <login-modal></login-modal>
          <div @click="toggleLoginModal()" class="login-modal-overlay"></div>
        </div>
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
                <div v-if="!isAuth" @click="toggleLoginModal()" class="pointer">
                  <i class="fa fa-user" aria-hidden="true"></i> Войти
                </div>
                <div v-else>
                  <i class="fa fa-user" aria-hidden="true"></i> {{ userData.name }}
                </div>
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
          <div v-if="categories" v-for="parentCategory of categories" class="nav-category">
            <router-link key="parentCategory.url" :to="'/category/' + parentCategory.url">{{ parentCategory.name }}</router-link>
            <div class="nav-subcategories">
              <div class="col-xs-6">
                <router-link class="block" key="subcategory.url" v-for="subcategory of parentCategory.subcategories" :to="'/category/' + parentCategory.url + '/' + subcategory.url">{{ subcategory.name }}</router-link>
              </div>
              <div class="col-xs-6">
                <div class="block">
                  <img :src="/img/ + parentCategory.image">
                </div>
              </div>
            </div>
          </div>
  <!--         <router-link to="/">Home</router-link>
          <router-link to="/brands">Brands</router-link>
          <router-link to="/contacts">Contacts</router-link> -->
        </nav>
      </header>
      <main class="container-fluid">
        <transition name="fade" mode="out-in">
          <router-view :key="$route.path" class="container-fluid"></router-view>
        </transition>
      </main>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'
import Search from './components/Search.vue'
import Cart from './components/layouts/Cart.vue'
import LoginModal from './components/layouts/LoginModal.vue'

export default {
  data() {
    return {
      classes: {
        mainClasses: {
          'cart-opened': false,
        },
        loginModalClasses: {
          'active': false,
          'modal-active': false,
        }
      }
    }
  },
  computed: {
    ...mapGetters({
      isAuth: 'user/isAuth',
      userData: 'user/userData',
      categories: 'categories/getAllCategories'
    })
  },
  methods: {
    ...mapActions({
      getAllCategories: 'categories/getAllCategories',
      checkAuth: 'user/checkAuth'
    }),
    cartToggle() {
      this.classes.mainClasses['cart-opened'] = !this.classes.mainClasses['cart-opened']
    },
    toggleLoginModal() {
      this.classes.loginModalClasses['active'] = !this.classes.loginModalClasses['active']
    }
  },
  mounted() {
    this.checkAuth()
    this.getAllCategories(this.$route.params)
  },
  watch: {
    'isAuth': {
      handler: function() {
        console.log(this.isAuth)
      }
    }
  },
  name: 'app',
  components: { Search, Cart, LoginModal }
}
</script>
