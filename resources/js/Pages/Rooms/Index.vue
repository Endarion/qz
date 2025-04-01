<template>
    <div class="rooms-container">
        <h1 class="text-2xl font-bold mb-4">Список комнат</h1>
        <PrimaryButton @click="goToCreate" class="mb-4">Создать комнату</PrimaryButton>
        <ul>
            <li v-for="room in rooms" :key="room.id" class="flex items-center space-x-2">
                <div class="flex items-center space-x-2">
                    <PrimaryButton @click="goToRoom(room.id)">{{ room.name }}</PrimaryButton>
                </div>

                <div class="text-gray-600">
                    <span class="mr-4">Категория: <DynamicIcon :icon="room.category.icon"
                                                               size="lg"/> {{ room.category.name }}</span>
                    <span class="mr-4">Игроки: {{ room.players.length }} / {{ room.players_count || 0 }}</span>
                    <span>Вопросов: {{ room.questions_count }}</span>
                    <span class="ml-4">Время на ответы: {{ room.answer_time }} секунд</span>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue"
import {router, usePage} from "@inertiajs/vue3"
import DynamicIcon from "@/Components/DynamicIcon.vue";

const props = defineProps(['rooms']);
const page = usePage();

console.log('rooms: ', props.rooms);

const goToRoom = (id) => {
    router.get(`/rooms/${id}`);
};

const goToCreate = () => {
    router.get(route('rooms.store'))
}
</script>

<style scoped>
.rooms-container {
    padding: 20px;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    margin: 10px 0;
}

span {
    margin-left: 10px;
}
</style>
