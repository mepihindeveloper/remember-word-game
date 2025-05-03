<script setup>
import StandardButton from '@/components/StandardButton.vue'
import Score from "@/components/Score.vue";
import Card from "@/components/Card.vue";
import {ref, watch} from "vue";
import {
  API_ENDPOINT, DEFAULT_SCORE,
  STATE_CLOSED,
  STATE_OPENED,
  STATUS_FAILED,
  STATUS_PENDING
} from "@/constants.js";
import Loader from "@/Loader.vue";

const scorePoints = ref(DEFAULT_SCORE);
const data = ref([])
const loading = ref(false)

watch(scorePoints, () => {
  if (scorePoints.value <= 0) {
    alert('Провал')
    data.value = []
    scorePoints.value = DEFAULT_SCORE
  }
})

function onFlip(word) {
  for (const card of data.value) {
    if (card.word !== word) {
      continue;
    }
    card.state = card.state === STATE_CLOSED ? STATE_OPENED : STATE_CLOSED;
  }
}

function onChangeStatus(word, status) {
  let isWordFound = false;
  for (const card of data.value) {
    if (card.word !== word) {
      continue;
    }
    if (card.status !== STATUS_PENDING) {
      continue;
    }
    card.status = status;
    isWordFound = true
  }
  if (isWordFound) {
    scorePoints.value = status === STATUS_FAILED ? scorePoints.value - 4 : scorePoints.value + 10;
  }
}

async function start() {
  loading.value = true
  await getData()
  scorePoints.value = DEFAULT_SCORE;
  loading.value = false
}

async function getData() {
  const response = await fetch(`${API_ENDPOINT}/`)
  if (response.status !== 200) {
    data.value = [];
    return
  }
  data.value = await response.json()
  for (const [key, value] of Object.entries(data.value)) {
    let number = parseInt(key) + 1;
    value.number = number < 10 ? `0${number}` : `${number}`
    value.state = STATE_CLOSED
    value.status = STATUS_PENDING
  }
}
</script>

<template>
  <header class="header">
    <h1 class="title">Запомни слово</h1>
    <score v-bind:score="scorePoints"/>
  </header>

  <main class="main">
    <loader v-if="loading"/>
    <template v-else>
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
    </template>
  </main>

</template>

<style scoped>
.header {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  padding: 49px 66px;
  height: 120px;
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
  justify-items: center;
}
@media (max-width: 980px) {
  .cards {
    grid-template-columns: 1fr 1fr 1fr;
  }
}
@media (max-width: 768px) {
  .cards {
    grid-template-columns: 1fr 1fr;
    padding: 0 66px;
    gap: 57px;
  }
}
@media (max-width: 460px) {
  .cards {
    grid-template-columns: 1fr;
  }
}
</style>
