<template>
  <div id="app">
    <header>
      <nav>
        <router-link to="/">Home</router-link>
        <router-link to="/brands">Brands</router-link>
        <router-link to="/contacts">Contacts</router-link>
      </nav>
      <search></search>
    </header>
    <main>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
import Search from './components/Search.vue'
import Results from './components/Results.vue'

export default {
  name: 'app',
  components: { Search }
}
</script>
