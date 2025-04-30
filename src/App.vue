<script setup>
import StandardButton from '@/components/StandardButton.vue'
import Score from "@/components/Score.vue";
import Card from "@/components/Card.vue";
import {ref} from "vue";

const scorePoints = ref(100);
const cards = ref([
  {
    word: 'word 1',
    translation: 'слово 1',
    state: 'closed',
    status: 'pending',
    number: '01',
  },
  {
    word: 'word 2',
    translation: 'слово 2',
    state: 'opened',
    status: 'pending',
    number: '02',
  },
  {
    word: 'word 3',
    translation: 'слово 3',
    state: 'opened',
    status: 'success',
    number: '03',
  },
  {
    word: 'word 4',
    translation: 'слово 4',
    state: 'opened',
    status: 'failed',
    number: '04',
  },
])

function onFlip(newState) {
  console.log('Flip event', newState)
}
function onChangeStatus(status) {
  console.log(status)
}
</script>

<template>
  <header class="header">
    <h1 class="title">Запомни слово</h1>
    <score v-bind:score="scorePoints" />
  </header>
  <main class="main">
    <div class="cards">
      <card
        v-for="card in cards"
        :key="card.number"
        v-bind="card"
        v-model:statusModel="card.status"
        @flip="onFlip"
        @change-status="onChangeStatus"
      />
    </div>
    <standard-button>Начать игру</standard-button>
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
