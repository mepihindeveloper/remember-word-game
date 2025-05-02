<script setup>
import StandardButton from '@/components/StandardButton.vue'
import Score from "@/components/Score.vue";
import Card from "@/components/Card.vue";
import {onMounted, ref} from "vue";

const API_ENDPOINT = 'http://localhost:8080/api'

const scorePoints = ref(100);
const data = ref([])

function onFlip(word) {
  for (const card of data.value) {
    if (card.word !== word) {
      continue;
    }
    card.state = card.state === 'closed' ? 'opened' : 'closed';
  }
}
function onChangeStatus(word, status) {
  for (const card of data.value) {
    if (card.word !== word) {
      continue;
    }
    card.status = status;
  }
}

function start() {
  getData()
  scorePoints.value = 100;
}

async function getData() {
  const response = await fetch(`${API_ENDPOINT}/random-words`)
  if (response.status !== 200) {
    data.value = [];
    return
  }
  data.value = await response.json()
  for (const [key, value] of Object.entries(data.value)) {
    let number = parseInt(key) + 1;
    value.number = key < 10 ? `0${number}` : number
    value.state = 'closed'
    value.status = 'pending'
  }
}
</script>

<template>
  <header class="header">
    <h1 class="title">Запомни слово</h1>
    <score v-bind:score="scorePoints" />
  </header>
  <main class="main">
    <div v-if="data.length" class="cards">
      <card
        v-for="card in data"
        :key="card.word"
        v-bind="card"
        @flip="onFlip"
        @change-status="onChangeStatus"
      />
    </div>
    <standard-button v-if="!data.length" @click="start">Начать игру</standard-button>
    <standard-button v-else @click="start">Начать заново</standard-button>
  </main>

</template>

<style scoped>
.header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 49px 66px;
}
.title {
  font-family: var(--font);
  font-weight: 700;
  font-size: 16px;
  line-height: 24px;
  text-transform: uppercase;
  color: var(--color-black-light);
}
.main {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 101px;
  flex-direction: column;
  padding-top: 49px;
  padding-bottom: 65px;
}
.cards {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr 1fr;
  width: 100%;
  padding: 0 66px;
  gap: 107px;
}
</style>
