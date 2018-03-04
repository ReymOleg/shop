<template>
  <div id="parent" class="wrapper">
    <vue-snotify></vue-snotify>
    <div id="content" :class="classes.mainClasses">
      <header class="container-fluid">
        <cart cartClose="cartClose()"></cart>
        <div id="cart-overlay" @click="closeAll()"></div>
        <div v-if="!isAuth" class="login-modal-block" :class="classes.loginModalClasses">
          <login-modal></login-modal>
          <div @click="toggleLoginModal()" class="login-modal-overlay"></div>
        </div>
        <div class="row top-header">
          <div class="header-logo col-xs-2 col-sm-4">
            <router-link to="/" class="logo-link">LOGO</router-link>
            <button @click="menuOpen()" class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></button>
          </div>
          <div class="header-center col-xs-6 col-sm-4">
            <search></search>
          </div>
          <div class="header-right col-xs-4 col-sm-4">
            <div class="row">
              <div class="col-xs-4">
                <div v-if="!isAuth" @click="toggleLoginModal()" class="pointer">
                  <i class="fa fa-user" aria-hidden="true"></i> <span class="hidden-xs">Войти</span>
                </div>
                <div v-else>
                  <div class="logged-user" v-click-outside="loggedMenuClose" @click="loggedMenuToggle()">
                    <i class="fa fa-user" aria-hidden="true"></i> <span class="hidden-xs">{{ userData.name }}</span>
                    <div class="logged-menu" :class="classes.loggedMenuClasses">
                      <div class="orders">Мои заказы</div>
                      <div class="logout" @click="logout()">Выйти</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-8 pointer">
                <div @click="cartOpen()">
                  <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="hidden-xs">Корзина</span> (<span>{{ cart.length || 0 }}</span>)
                </div>
              </div>
            </div>
          </div>
        </div>
        <nav class="container-fluid center" :class="classes.menuClasses">
          <div class="nav-category" @click="menuClose()">
            <router-link key="home" :to="'/'" class="hidden-home">Главная</router-link>
          </div>
          <div v-if="categories" v-for="parentCategory of categories" class="nav-category" @click="menuClose()">
            <router-link key="parentCategory.url" :to="'/category/' + parentCategory.url">{{ parentCategory.name }}</router-link>
            <div class="nav-subcategories">
              <div class="col-xs-8 col-sm-6">
                <router-link class="block" :key="subcategory.url" v-for="subcategory of parentCategory.subcategories" :to="'/category/' + parentCategory.url + '/' + subcategory.url" @click="menuClose()">{{ subcategory.name }}</router-link>
              </div>
              <div class="col-xs-4 col-sm-6">
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
import Snotify from 'vue-snotify'
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
          'menu-opened': false,
        },
        menuClasses: {
          'active': false,
        },
        loginModalClasses: {
          'active': false,
          'modal-active': false,
        },
        loggedMenuClasses: {
          'active': false,
        },
      }
    }
  },
  computed: {
    ...mapGetters({
      isAuth: 'user/isAuth',
      userData: 'user/userData',
      categories: 'categories/getAllCategories',
      cart: 'products/cart'
    })
  },
  methods: {
    ...mapActions({
      getAllCategories: 'categories/getAllCategories',
      checkAuth: 'user/checkAuth',
      getCart: 'products/getCart',
      userLogout: 'user/logout',
    }),
    logout() {
      let _self = this;

        this.$snotify.async(
          'Пожалуйста ожидайте',
          'Авторизация',
          () => new Promise((resolve, reject) => {
            _self.userLogout()
              .then((response) => {
                resolve({
                  title: 'До свидания!',
                  body: 'возвращайтесь снова :)',
                  config: {
                    closeOnClick: true,
                    timeout: 2000
                  }
                })
              })
              .catch((e) => {
                reject({
                  title: 'Ошибка!',
                  body: 'Что-то пошло не так...',
                  config: {
                    closeOnClick: true,
                    timeout: 3000
                  }
                })
              })
          })
        )
      
    },
    cartOpen() {
      this.classes.mainClasses['cart-opened'] = true
    },
    cartClose() {
      this.classes.mainClasses['cart-opened'] = false
    },
    toggleLoginModal() {
      this.classes.loginModalClasses['active'] = !this.classes.loginModalClasses['active']
    },
    menuOpen() {
      this.classes.mainClasses['menu-opened'] = true
    },
    menuClose() {
      this.classes.mainClasses['menu-opened'] = false
    },
    loggedMenuToggle(e, param) {
      this.classes.loggedMenuClasses['active'] = !this.classes.loggedMenuClasses['active']
    },
    loggedMenuClose() {
      this.classes.loggedMenuClasses['active'] = false
    },
    closeAll() {
      this.menuClose()
      this.cartClose()
    }
  },
  mounted() {
    this.checkAuth()
    this.getCart()
    this.getAllCategories(this.$route.params)
  },
  // watch: {
  //   'isAuth': {
  //     handler: function() {
  //       // console.log(this.isAuth)
  //     }
  //   },
  //   'userData': {
  //     handler: function() {
  //       // console.log(this.userData)
  //     }
  //   },
  // },
  name: 'app',
  components: { Search, Cart, LoginModal },
}
</script>
