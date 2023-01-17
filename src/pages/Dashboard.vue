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
    borderColor: '#e0ca3c',
    backgroundColor: '#e0ca3c99',
    fill: true,
    plugins: {
      legend: {
        display: false,
      },
      title: {
        display: true,
        text: 'Pages read',
        color: '#fff9',
      },
    },
  }

  const advancements = ref({ labels: [], datasets: [] })

  axios
    .get(`${import.meta.env.VITE_APP_API_URL}advancements.json`, {
      headers: { Token: store.value.user.token },
    })
    .then(res => {
      const pages = []
      Object.values(res.data.advancements).forEach(a => {
        const pageData = pages.find(p => p.date == a.date)
        if (!pageData) {
          pages.push({ date: a.date, pages: a.pages })
        } else {
          pageData.pages += a.pages
        }
      })
      pages.sort((a, b) => (a.date > b.date ? 1 : -1))
      console.log(pages)
      advancements.value = {
        labels: pages.map(p => p.date),
        datasets: [
          {
            label: 'Pages',
            data: pages.map(p => p.pages),
          },
        ],
      }
    })
    .catch(err => console.error(err))
</script>

<template>
  <AddReadingForm />

  <section>
    <h4>Statistics for 2023-01-01 - 2023-01-08</h4>
    <Line id="advancements" :options="chartOptions" :data="advancements" />
  </section>
</template>

<style scoped></style>
