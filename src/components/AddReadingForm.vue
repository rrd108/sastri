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
  <div>
    <input type="date" v-model="date" />
    <select v-model="book">
      <option v-for="book in books">{{ book.title }}</option>
    </select>
  </div>
  <div>
    <input type="number" v-model.number="pages" class="right" />
    <button>Ment</button>
  </div>
</template>

<style scoped>
  div {
    display: flex;
    gap: 0.5em;
    justify-content: center;
  }
  input[type='number'],
  button {
    width: 6em;
  }
</style>
