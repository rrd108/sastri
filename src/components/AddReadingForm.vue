<script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios'
  import store from '@/store'

  const date = ref(new Date().toISOString().split('T')[0])
  const pages = ref(0)
  const book = ref('')
  const books = ref([])

  axios
    .get(`${import.meta.env.VITE_APP_API_URL}books.json`, {
      headers: { Token: store.value.user.token },
    })
    .then(res => {
      books.value = res.data.books
    })
    .catch(err => console.error(err))
</script>

<template>
  <input type="date" v-model="date" />
  <select v-model="book">
    <option v-for="book in books">{{ book.title }}</option>
  </select>
  <input type="number" v-model.number="pages" />
  <button>Ment</button>
</template>

<style scoped></style>
