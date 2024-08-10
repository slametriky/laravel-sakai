<script setup>
import { useForm } from "@inertiajs/vue3";
import { watchEffect, reactive } from "vue";

const props = defineProps({
    show: Boolean,
    title: String,
    role: Object,
    permissions: Object,
});

const data = reactive({
    multipleSelect: false,
});

const emit = defineEmits(["close"]);

const form = useForm({
    name: "",
    permissions: [],
});

const update = () => {
    form.put(route("role.update", props.role?.id), {
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
        form.name = props.role?.name;
        form.permissions = props.role.permissions?.map((d) => d.id);
    }
    if (props.permissions.length == props.role?.permissions.length) {
        data.multipleSelect = true;
    } else {
        data.multipleSelect = false;
    }
});

const selectAll = (event) => {
    if (event.target.checked === false) {
        form.permissions = [];
    } else {
        form.permissions = [];
        props.permissions.forEach((permission) => {
            form.permissions.push(permission.id);
        });
    }
};
const select = () => {
    if (props.permissions.length == form.permissions.length) {
        data.multipleSelect = true;
    } else {
        data.multipleSelect = false;
    }
};


</script>

<template>
     <Dialog v-model:visible="props.show" position="center" modal :header="'Update ' + props.title" :style="{ width: '50rem' }" :closable="false">
        <form @submit.prevent="update">
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <label for="name">Name</label>
                    <InputText id="name" v-model="form.name" class="flex-auto" autocomplete="off" placeholder="Name" />    
                    <small v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</small>  
                </div>
                <div class="flex flex-col">
                    <label for="permissions">Permissions</label>

                    <div class="flex justify-start items-center space-x-2 mt-2">
                        
                        <Checkbox v-model="data.multipleSelect" @change="selectAll" inputId="check_all" :binary="true"  />
                        <label for="check_all" class="ml-2"> Check All </label>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mt-2">
                        <div
                            class="flex items-center justify-start space-x-2"
                            v-for="(permission, index) in props.permissions"
                            :key="index"
                        >
                            <Checkbox v-model="form.permissions" @change="select" :inputId="'permission_' + permission.id" :value="permission.id"   />
                            <label :for="'permission_' + permission.id" class="ml-2"> {{ permission.name }} </label>
                        </div>
                    </div>

                    <small v-if="form.errors.permissions" class="text-red-500">{{ form.errors.permissions }}</small>  

                </div>
                <div class="flex justify-end gap-2">
                    <Button type="button" label="Cancel" severity="secondary" @click="emit('close')"></Button>
                    <Button type="submit" label="Update"></Button>
                </div> 
            </div>
        </form>
    </Dialog>
</template>
