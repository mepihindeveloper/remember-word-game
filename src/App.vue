<script setup>
import StandardButton from '@/components/StandardButton.vue'
import Score from "@/components/Score.vue";
import Card from "@/components/Card.vue";

const score = 100;
const cardData = {
  number: '01',
  text: 'unadmitted',
  status: undefined
}
</script>

<template>
  <header class="header">
    <h1 class="title">Запомни слово</h1>
    <score :score />
  </header>
  <main class="main">
    <card v-bind="cardData" />
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
  display: grid;
  align-items: center;
  justify-content: center;
  align-content: center;
  gap: 10px;
}
</style>
