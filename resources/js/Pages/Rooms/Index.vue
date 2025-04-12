<template>
    <div class="rooms-container">
        <h1 class="text-2xl font-bold mb-4">Список комнат</h1>

        <PrimaryButton @click="openCreateModal" class="mb-4">Создать комнату</PrimaryButton>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="room in rooms" :key="room.id"
                 class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition">
                <h2 class="text-lg font-semibold">{{ room.name }}</h2>
                <p class="text-gray-600">Категория:
                    <DynamicIcon :icon="room.category.icon"
                                 size="lg"/>
                    {{ room.category.name }}
                </p>
                <p class="text-gray-600">Игроки: {{ room.players.length }} / {{ room.players_count || 0 }}</p>
                <p class="text-gray-600">Вопросов: {{ room.questions_count }}</p>
                <p class="text-gray-600">Время на ответы: {{ room.answer_time }} секунд</p>

                <div class="mt-2 flex space-x-2">
                    <PrimaryButton @click="goToRoom(room.id)">Перейти в комнату</PrimaryButton>
                </div>
            </div>
        </div>

        <TransitionRoot appear :show="isCreateModalOpen" as="template">
            <Dialog as="div" class="relative z-10" @close="closeCreateModal">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay class="fixed inset-0 bg-black opacity-30"/>
                </TransitionChild>

                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full max-w-md transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 p-6 shadow-xl transition-all"
                            >
                                <DialogTitle as="h3" class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Создать новую комнату
                                </DialogTitle>
                                <form @submit.prevent="submitForm" class="space-y-6 mt-4">
                                    <div>
                                        <InputLabel for="name" value="Название комнаты"
                                                    class="text-gray-900 dark:text-white"/>
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
                                    </div>

                                    <div>
                                        <InputLabel for="category_id" value="Категория"
                                                    class="text-gray-900 dark:text-white"/>
                                        <Listbox v-model="form.category_id" :disabled="!categories?.length">
                                            <div class="relative mt-1">
                                                <ListboxButton
                                                    class="relative w-full cursor-default rounded-md border border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 py-2 pl-3 pr-10 text-left shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm"
                                                    :class="{ 'border-red-500': form.errors.category_id }"
                                                >
                                                    <span class="flex items-center">
                                                        <DynamicIcon
                                                            v-if="selectedCategory"
                                                            :icon="selectedCategory.icon"
                                                            class="mr-2 text-gray-400"
                                                            size="lg"
                                                        />
                                                        <span
                                                            :class="[
                                                                selectedCategory ? 'text-gray-900 dark:text-gray-200' : 'text-gray-500',
                                                                'block truncate'
                                                            ]"
                                                        >
                                                            {{ selectedCategory?.name || 'Выберите категорию' }}
                                                        </span>
                                                    </span>
                                                    <span
                                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                        <DynamicIcon icon="fas fa-chevron-down"
                                                                     class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                    </span>
                                                </ListboxButton>

                                                <Transition
                                                    leave-active-class="transition ease-in duration-100"
                                                    leave-from-class="opacity-100"
                                                    leave-to-class="opacity-0"
                                                >
                                                    <ListboxOptions
                                                        class="absolute z-20 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-gray-700 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                                                    >
                                                        <ListboxOption
                                                            v-for="category in categories"
                                                            :key="category.id"
                                                            :value="category.id"
                                                            as="template"
                                                            v-slot="{ active, selected }"
                                                        >
                                                            <li
                                                                :class="[
                                                                    active ? 'bg-indigo-600 text-white dark:bg-indigo-500' : 'text-gray-900 dark:text-gray-200',
                                                                    'relative cursor-default select-none py-2 pl-3 pr-9'
                                                                ]"
                                                            >
                                                                <span class="flex items-center">
                                                                    <DynamicIcon :icon="category.icon"
                                                                                 class="mr-2 text-gray-400" size="lg"/>
                                                                    {{ category.name }}
                                                                </span>
                                                                <span
                                                                    v-if="selected"
                                                                    :class="[active ? 'text-white' : 'text-indigo-600 dark:text-indigo-400', 'absolute inset-y-0 right-0 flex items-center pr-4']"
                                                                >
                                                                    <DynamicIcon icon="fas fa-check" class="h-5 w-5"
                                                                                 aria-hidden="true"/>
                                                                </span>
                                                            </li>
                                                        </ListboxOption>
                                                    </ListboxOptions>
                                                </Transition>
                                            </div>
                                        </Listbox>
                                        <InputError class="mt-2" :message="form.errors.category_id"/>
                                    </div>

                                    <div class="flex items-center">
                                        <Checkbox id="is_public" v-model="form.is_public" checked/>
                                        <InputLabel
                                            for="is_public"
                                            value="Публичная комната"
                                            class="ml-2 text-gray-900 dark:text-white"
                                        />
                                    </div>

                                    <div v-if="!form.is_public">
                                        <InputLabel for="password" value="Пароль"
                                                    class="text-gray-900 dark:text-white"/>
                                        <TextInput
                                            id="password"
                                            v-model="form.password"
                                            type="password"
                                            class="mt-1 block w-full"
                                            placeholder="Введите пароль"
                                        />
                                        <InputError class="mt-2" :message="form.errors.password"/>
                                    </div>

                                    <div>
                                        <InputLabel for="players_count" value="Количество игроков"
                                                    class="text-gray-900 dark:text-white"/>
                                        <TextInput
                                            id="players_count"
                                            v-model.number="form.players_count"
                                            type="number"
                                            class="mt-1 block w-full"
                                            min="2"
                                            max="4"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.players_count"/>
                                    </div>

                                    <div>
                                        <InputLabel for="questions_count" value="Количество вопросов"
                                                    class="text-gray-900 dark:text-white"/>
                                        <TextInput
                                            id="questions_count"
                                            v-model.number="form.questions_count"
                                            type="number"
                                            class="mt-1 block w-full"
                                            min="5"
                                            max="30"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.questions_count"/>
                                    </div>

                                    <div>
                                        <InputLabel for="answer_time" value="Время на ответ"
                                                    class="text-gray-900 dark:text-white"/>
                                        <TextInput
                                            id="answer_time"
                                            v-model.number="form.answer_time"
                                            type="number"
                                            class="mt-1 block w-full"
                                            min="10"
                                            max="30"
                                            required
                                        />

                                        <InputError class="mt-2" :message="form.errors.answer_time"/>
                                    </div>

                                    <div class="flex justify-end space-x-2">
                                        <PrimaryButton type="button" @click="closeCreateModal"
                                                       class="bg-gray-500 hover:bg-gray-600">
                                            Отмена
                                        </PrimaryButton>
                                        <PrimaryButton :disabled="form.processing">Создать</PrimaryButton>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script setup>

import PrimaryButton from "@/Components/PrimaryButton.vue"
import {router, useForm} from "@inertiajs/vue3"
import DynamicIcon from "@/Components/DynamicIcon.vue";
import {
    Dialog,
    DialogOverlay,
    DialogPanel,
    DialogTitle,
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";
import {computed, ref} from "vue";

const props = defineProps(['rooms', 'categories']);

const isCreateModalOpen = ref(false);
const form = useForm({
    name: '',
    is_public: true,
    password: null,
    players_count: 2,
    questions_count: 10,
    answer_time: 15,
    players: [],
    category_id: null
});

const selectedCategory = computed(() => {
    return props.categories?.find(category => category.id === form.category_id) || null;
});

const goToRoom = (id) => router.get(route('rooms.show', {room: id}));
const openCreateModal = () => {
    isCreateModalOpen.value = true;
    form.reset();
};

const closeCreateModal = () => {
    isCreateModalOpen.value = false;
    form.reset();
};

const submitForm = () => {
    console.log('Submitting form with data:', form.data());
    form.post(route('rooms.store'), {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
            console.log('Form submitted successfully, room_id:', page.props.room_id);
            const roomId = page.props.room_id;
            closeCreateModal();
            router.get(route('rooms.show', {room: roomId}));
        },
        onError: (errors) => {
            console.log('Form submission errors:', errors);
        },
    });
};
</script>

<style scoped>
.rooms-container {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.grid {
    display: grid;
}
</style>
