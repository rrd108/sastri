<script setup lang="ts"></script>

<template>
  <h1>Sastri</h1>
  <input type="date" v-model="date" />
  <select v-model="book">
    <option v-for="book in books">{{ book.title }}</option>
  </select>
  <input type="number" v-model.number="pages" />
  <button>Ment</button>
</template>

<style scoped></style>
