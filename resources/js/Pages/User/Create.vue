<script setup>
import { useForm } from "@inertiajs/vue3";
import { watchEffect } from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    roles: Object,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role: "admin",
});

const create = () => {
    form.post(route("user.store"), {
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
    }
});

</script>

<template>
    <Dialog v-model:visible="props.show" position="top" modal :header="'Add ' + props.title" :style="{ width: '30rem' }" :closable="false">
        <form @submit.prevent="create">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name">Name</label>
                    <InputText id="name" v-model="form.name" class="flex-auto" autocomplete="off" placeholder="Name" />    
                    <small v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</small>  
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email">Email</label>
                    <InputText id="email" v-model="form.email" class="flex-auto" autocomplete="off" placeholder="Email" />
                    <small v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</small>  
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password">Password</label>
                    <InputText id="password" v-model="form.password" type="password" placeholder="Password" />
                    <small v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</small>  
                </div>
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation">Confirmation Password</label>
                    <InputText id="password_confirmation" v-model="form.password_confirmation" type="password" placeholder="Confirmation Password" />
                    <small v-if="form.errors.password_confirmation" class="text-red-500">{{ form.errors.password_confirmation }}</small>  
                </div>
                <div class="flex flex-col gap-2">
                    <label for="role">Role</label>
                    <Select v-model="form.role" :options="props.roles" optionValue="code" optionLabel="name" placeholder="Select" />
                    <small v-if="form.errors.role" class="text-red-500">{{ form.errors.role }}</small>  

                </div>
                <div class="flex justify-end gap-2">
                    <Button type="button" label="Cancel" severity="secondary" @click="emit('close')"></Button>
                    <Button type="submit" label="Save"></Button>
                </div> 
            </div>
        </form>
    </Dialog>
</template>
