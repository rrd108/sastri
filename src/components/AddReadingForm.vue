<script setup lang="ts">
  import { ref } from 'vue'
  import axios from 'axios'
  import store from '@/store'

  const date = ref(new Date().toISOString().split('T')[0])
  const pages = ref(0)
  const book = ref('')

  if (!store.value.books.length) {
    axios
      .get(`${import.meta.env.VITE_APP_API_URL}books.json`, {
        headers: { Token: store.value.user.token },
      })
      .then(res => {
        store.value.books = res.data.books
        sessionStorage.setItem('books', JSON.stringify(res.data.books))
      })
      .catch(err => console.error(err))
  }

  const errorFields = ref({ date: false, book: false, pages: false })
  const save = () => {
    errorFields.value = { date: false, book: false, pages: false }
    if (!date.value) {
      errorFields.value.date = true
    }
    if (!book.value) {
      errorFields.value.book = true
    }
    if (!pages.value) {
      errorFields.value.pages = true
    }
    if (
      errorFields.value.date ||
      errorFields.value.book ||
      errorFields.value.pages
    ) {
      return
    }

    axios
      .post(
        `${import.meta.env.VITE_APP_API_URL}advancements.json`,
        {
          date: date.value,
          book_id: store.value.books.find(b => b.title == book.value)?.id || 0,
          pages: pages.value,
        },
        {
          headers: { Token: store.value.user.token },
        }
      )
      .then(res => store.value.advancements.push(res.data.advancement))
      .catch(err => console.error(err))
  }

  const removeError = (field: 'date' | 'book' | 'pages') => {
    if ((field == 'pages' && pages.value > 0) || field != 'pages') {
      errorFields.value[field] = false
    }
  }
</script>

<template>
  <div>
    <input
      type="date"
      v-model="date"
      :class="{ error: errorFields.date }"
      @change="removeError('date')"
    />
    <select
      v-model="book"
      :class="{ error: errorFields.book }"
      @change="removeError('book')"
    >
      <option v-for="book in store.books">{{ book.title }}</option>
    </select>
  </div>
  <div>
    <input
      type="number"
      v-model.number="pages"
      class="right"
      :class="{ error: errorFields.pages }"
      @change="removeError('pages')"
    />
    <button @click="save">Ment</button>
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
  .error {
    background-color: var(--error);
  }
</style>
