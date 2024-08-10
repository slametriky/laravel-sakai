<script setup>
import { useForm } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    permission: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
});

const update = () => {
    form.put(route("permission.update", props.permission?.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit("close");
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
};

watchEffect(() => {
    if (props.show) {
        form.errors = {};
        form.name = props.permission?.name;
    }
});


</script>

<template>
     <Dialog v-model:visible="props.show" position="center" modal :header="'Update ' + props.title" :style="{ width: '30rem' }" :closable="false">
        <form @submit.prevent="update">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name">Name</label>
                    <InputText id="name" v-model="form.name" class="flex-auto" autocomplete="off" placeholder="Name" />    
                    <small v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</small>  
                </div>
                <div class="flex justify-end gap-2">
                    <Button type="button" label="Cancel" severity="secondary" @click="emit('close')"></Button>
                    <Button type="submit" label="Update"></Button>
                </div> 
            </div>
        </form>
    </Dialog>
</template>
