<template>
  <div id="app" class="wrapper">
    <header class="container-fluid">
      <div class="row top-header">
        <div class="header-logo col-xs-4">
          <router-link to="/">LOGO</router-link>
        </div>
        <div class="header-right col-xs-4">
          <search></search>
        </div>
        <div class="header-left col-xs-4">
          Some info
        </div>
      </div>
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/brands">Brands</router-link>
        <router-link to="/contacts">Contacts</router-link>
      </nav>
    </header>
    <main>
      <transition name="fade" mode="out-in">
        <keep-alive>
          <router-view></router-view>
        </keep-alive>
      </transition>
    </main>
  </div>
</template>

<script>
import Search from './components/Search.vue'

export default {
  name: 'app',
  components: { Search }
}
</script>
