<script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios'

  const date = ref(new Date().toISOString().split('T')[0])
  const pages = ref(0)
  const book = ref('')
  const books = ref([])

  axios
    .get('http://localhost/~rrd/sastri/api/books.json', {
      headers: { Token: '2SJqcDVpH9PifK6tE0FdxrGuhYe4ArbCriXW2bH02zcXf' },
    })
    .then(res => {
      books.value = res.data.books
    })
    .catch(err => console.error(err))
</script>

<template>
  <h1>Sastri</h1>
  <router-view />
  <input type="date" v-model="date" />
  <select v-model="book">
    <option v-for="book in books">{{ book.title }}</option>
  </select>
  <input type="number" v-model.number="pages" />
  <button>Ment</button>
</template>

<style scoped></style>
