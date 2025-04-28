<script setup>
</script>

<template>
  <button class="button">
    <slot />
  </button>
</template>

<style scoped>
  .button {
    width: 335px;
    border: none;
    border-radius: 100px;
    background: var(--color-primary);

    padding: 16px 10px;

    font-family: var(--font);
    font-size: 24px;
    font-weight: 400;
    line-height: 36px;
    color: var(--color-white);
    cursor: pointer;
    letter-spacing: 0;
    text-align: center;

  }
  .button:hover {
    background: var(--color-primary-inverted);
  }
</style>
