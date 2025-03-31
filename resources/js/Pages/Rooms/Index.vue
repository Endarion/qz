<template>
  <div>
    <h1>Комнаты</h1>
    <ul>
      <li v-for="r in rooms" :key="r.id">
        <PrimaryButton @click="goToRoom(r.id)">{{ r.name }}</PrimaryButton>
      </li>
    </ul>
  </div>
</template>

<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue"
import {router} from "@inertiajs/vue3"

defineProps(['rooms']);

const goToRoom = (id) => {
  router.get(`/rooms/${id}`);
};
</script>