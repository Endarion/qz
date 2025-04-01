<template>
    <div class="create-room-container">
        <h1 class="text-2xl font-bold text-center mb-6">Создание комнаты</h1>

        <form @submit.prevent="submitForm" class="space-y-6">
            <div>
                <InputLabel for="name" value="Название комнаты"/>

                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Введите название"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.name"/>

                <div class="flex items-center">
                    <Checkbox id="is_public" v-model="form.is_public" checked/>
                    <InputLabel for="is_public" value="Открытая комната" class="ml-2"/>
                </div>

                <div v-if="!form.is_public">
                    <InputLabel for="password" value="Пароль"/>
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="Пароль комнаты"
                    />
                    <InputError class="mt-2" :message="form.errors.password"/>
                </div>

                <div>
                    <InputLabel for="players_count" value="Количество игроков"/>
                    <TextInput
                        id="players_count"
                        v-model="form.players_count"
                        type="number"
                        class="mt-1 block w-full"
                        value="2"
                        min="2"
                        max="4"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.players_count"/>
                </div>

                <div>
                    <InputLabel for="questions_count" value="Количество вопросов"/>
                    <TextInput
                        id="questions_count"
                        v-model="form.questions_count"
                        type="number"
                        class="mt-1 block w-full"
                        value="2"
                        min="5"
                        max="30"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.questions_count"/>
                </div>

                <!--        TODO:: answer_time -->

                <div class="flex justify-end">
                    <PrimaryButton :disabled="form.processing">
                        Создать комнату
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import {router, useForm} from "@inertiajs/vue3"
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: '',
    is_public: true,
    password: null,
    players_count: 2,
    questions_count: 10,
    answer_time: 15,
    players: [],
    category: []
});

const submitForm = () => {
    form.post(route('rooms.store'), {
        onSuccess: (page) => {
            const roomId = page.props.room_id;
            router.get(route('rooms.show', {room: roomId}))
        },
        onError: () => {
            prompt('Ошибка создания комнаты');
            console.log('Ошибка создания комнаты: ', form.errors);
        }
    })
};
</script>

<style scoped>
.create-room-container {
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
}
</style>
