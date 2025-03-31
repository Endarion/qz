<template>
  <div>
    <h1>{{ room.name }}</h1>
    <p>Статус: {{ room.status }}</p>
    <ul>
      <li v-for="player in room.players" :key="player.id">{{ player.name }}</li>
    </ul>
    <button v-if="isHost" @click="startGame">Начать</button>
    <button @click="joinRoom">Присоединиться</button>
  </div>
</template>

<script setup>
import {router, useForm, usePage} from '@inertiajs/vue3';
import {computed, onMounted} from 'vue';

const props = defineProps(['room']);
const page = usePage();

const isHost = computed(() => page.props.auth.user?.id === props.room.host_id);
const joinForm = useForm({'password': ''});

const joinRoom = () => {
  if (!props.room.is_public) {
    joinForm.password = prompt('Пароль:')
  }
  joinForm.post(`/rooms/${props.room.id}/join`, {
    onSuccess: () => joinForm.reset(),
  });
};

const startGame = () => {
  router.post(`/rooms/${props.room.id}/start`)
};

onMounted(() => {
  window.Echo.channel('rooms').listen('RoomCreated', (e) => {
    if (e.room.id === props.room.id) {
      Object.assign(props.room, e.room);
    }
  });
});
</script>

<style scoped>
</style>