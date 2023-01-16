<script setup lang="ts">
  import axios from 'axios'
  import { ref } from 'vue'
  import store from '@/store'
  import router from '@/router'

  const email = ref('')
  const password = ref('')

  const login = () =>
    axios
      .post(`${import.meta.env.VITE_APP_API_URL}users/login.json`, {
        email: email.value,
        password: password.value,
      })
      .then(res => {
        store.value.user = res.data.user
        router.push('/dashboard')
      })
      .catch(err => console.error(err))
</script>

<template>
  <form @submit.prevent="login">
    <input type="text" v-model="email" />
    <input type="password" v-model="password" />
    <input type="submit" value="Belép" />
  </form>
</template>

<style scoped></style>
