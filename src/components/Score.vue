<script setup>
import HeartIcon from "@/components/icons/HeartIcon.vue";

const { score } = defineProps({
  score: {
    type: Number,
    default: 100,
  },
})
</script>

<template>
  <button class="score-button"> {{ score }} <heart-icon></heart-icon></button>
</template>

<style scoped>
.score-button {
  display: flex;
  flex-direction: row;
  align-items: center;

  border: none;
  border-radius: 36px;
  background: var(--color-primary-light);

  padding: 12px 24px;

  font-family: var(--font);
  font-size: 16px;
  font-weight: 700;
  line-height: 24px;
  color: var(--color-primary);
  letter-spacing: 0;
  text-align: center;

  box-shadow: 0 0 4px 0 #00000026;
  gap: 10px
}
</style>
