<script setup>
import FailIcon from "@/components/icons/FailIcon.vue";
import SuccessIcon from "@/components/icons/SuccessIcon.vue";
import StandardButton from "@/components/StandardButton.vue";
import {ref} from "vue";
const {
  number,
  word,
  translation,
  status,
  state,
} = defineProps({
  number: {
    type: String,
    default: '00',
  },
  word: {
    type: String,
    default: '',
  },
  translation: {
    type: String,
    default: '',
  },
  status: {
    type: String,
    default: 'pending',
  },
  state: {
    type: String,
    default: 'closed',
  },
})
const emit = defineEmits(['flip', 'change-status'])
function flip() {
  emit('flip', state === 'closed' ? 'opened' : 'closed')
}
function changeStatus(status) {
  emit('change-status', status)
}
</script>

<template>
  <div class="card">
    <div class="card__body">
      <div class="card__number">{{ number }}</div>
      <div v-if="status === 'failed' || status === 'success'" class="card__status large">
        <fail-icon v-if="status === 'failed'" class="large" />
        <success-icon v-else class="large" />
      </div>
      <div class="card-body__word">{{ state === 'closed' ? word : translation }}</div>
      <div class="card__actions">
        <button v-if="state === 'closed'" class="card__actions__flip" @click="flip">Перевернуть</button>
        <button v-else-if="state === 'opened' && (status === 'failed' || status === 'success')" class="card__actions__finished">Завершено</button>
        <div v-else class="card__actions__change-status">
          <button><fail-icon @click="changeStatus('failed')" /></button>
          <button><success-icon @click="changeStatus('success')" /></button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  background: var(--color-white);
  border-radius: 16px;
  box-shadow: 0 0 16px 0 #0000001A;
  padding: 28px 19px;
  position: relative;
  width: 250px;
}
.card__number {
  position: absolute;
  top: -8px;
  left: 16px;
  font-family: var(--font);
  font-weight: 400;
  font-size: 14px;
  line-height: 100%;
  letter-spacing: 0;
  text-align: center;
  color: var(--color-black);
  background: var(--color-white);
}
.card__status {
  display: flex;
  justify-content: center;
  position: absolute;
  top: -12px;
  background: var(--color-white);
}
.card__status.large {
  top: -24px;
}
.card__body {
  border: 1px solid var(--color-primary-light);
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  position: relative;
}
.card-body__word {
  padding: 177px 0;
  color: var(--color-black);
  font-family: var(--font);
  font-weight: 400;
  font-size: 18px;
  line-height: 100%;
  letter-spacing: 0;
  text-align: center;
  text-transform: lowercase;
}
.card__actions {
  background-color: var(--color-white);
  display: flex;
  justify-content: center;
  position: absolute;
  bottom: -16px;
  height: 30px;
}
.card__actions__flip, .card__actions__finished {
  background: none;
  border: none;
  font-family: var(--font);
  font-weight: 700;
  font-size: 12px;
  line-height: 18px;
  color: var(--color-black);
  text-transform: uppercase;
  cursor: pointer;
}
.card__actions__finished {
  cursor: context-menu;
}
.card__actions__change-status {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;
  gap: 32px;
}
.card__actions__change-status button {
  border: 0;
  background: none;
  cursor: pointer;
}
</style>
