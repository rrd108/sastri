<script setup lang="ts">
  import { ref } from 'vue'
  import store from '@/store'
  import AddReadingForm from '@/components/AddReadingForm.vue'
  import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Filler,
    Title,
    Tooltip,
    Legend,
  } from 'chart.js'
  import { Line } from 'vue-chartjs'
  import axios from 'axios'

  ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Filler,
    Title,
    Tooltip,
    Legend
  )

  const chartOptions = {
    responsive: true,
    borderColor: '#307351',
    fill: true,
  }

  const advancements = ref({ labels: [], datasets: [] })

  axios
    .get(`${import.meta.env.VITE_APP_API_URL}advancements.json`, {
      headers: { Token: store.value.user.token },
    })
    .then(res => {
      advancements.value = {
        labels: res.data.advancements.map(a => a.date),
        datasets: [
          {
            label: 'Pages',
            data: res.data.advancements.map(a => a.pages),
          },
        ],
      }
    })
    .catch(err => console.error(err))
</script>

<template>
  <h2>Dashboard</h2>
  <AddReadingForm />

  <section>
    <h4>Statistics for 2023-01-01 - 2023-01-08</h4>
    <Line id="advancements" :options="chartOptions" :data="advancements" />
  </section>
</template>

<style scoped></style>
