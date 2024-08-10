
<script setup>
import AppLayout from "@/sakai/layout/AppLayout.vue";
import Create from "@/Pages/Role/Create.vue";
import Edit from "@/Pages/Role/Edit.vue";
import { usePage, useForm } from '@inertiajs/vue3';

import { onMounted, reactive, ref, watch, computed } from "vue";
import pkg from "lodash";
import { router } from "@inertiajs/vue3";
const { _, debounce, pickBy } = pkg;
import { loadToast } from '@/composables/loadToast';

const props = defineProps({
    title: String,
    filters: Object,
    permissions: Object,
    roles: Object,
    perPage: Number,
});

loadToast();

const deleteDialog = ref(false);
const permissionDialog = ref(false);
const form = useForm({});

const data = reactive({
    params: {
        search: props.filters.search,
        field: props.filters.field,
        order: props.filters.order,
        createOpen: false,
        editOpen: false,
    },
    role: null,
});

const deleteData = () => {
    deleteDialog.value = false;
    
    form.delete(route("role.destroy", data.role?.id), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => null,
        onFinish: () => null,
    });
}


const onPageChange = (event) => {
    router.get(route('role.index'), { page: event.page + 1 }, { preserveState: true });
};

watch(
    () => _.cloneDeep(data.params),
    debounce(() => {
        let params = pickBy(data.params);
        router.get(route("role.index"), params, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);

</script>

<template>
    <app-layout>             
        <div class="card">            
            <Create
                :show="data.createOpen"
                @close="data.createOpen = false"
                :title="props.title"
                :permissions="props.permissions"
            />
            <Edit
                :show="data.editOpen"
                @close="data.editOpen = false"
                :role="data.role"
                :title="props.title"
                :permissions="props.permissions"
            />
            <Button v-show="can(['create role'])" label="Create" @click="data.createOpen = true" icon="pi pi-plus" />
            <DataTable lazy :value="roles.data" paginator  :rows="roles.per_page" :totalRecords="roles.total" :first="(roles.current_page - 1) * roles.per_page"   @page="onPageChange"  tableStyle="min-width: 50rem">
                <template #header>
                    <div class="flex justify-end">
                        <IconField>
                            <InputIcon>
                                <i class="pi pi-search" />
                            </InputIcon>
                            <InputText v-model="data.params.search" placeholder="Keyword Search" />
                        </IconField>
                    </div>
                </template>
                <template #empty> No data found. </template>
                <template #loading> Loading data. Please wait. </template>

                <Column header="No">
                    <template #body="slotProps">
                        {{slotProps.index + 1}}
                    </template>
                </Column>

                <Column field="name" header="Name"></Column>
                <Column field="guard_name" header="Guard"></Column>
                <Column header="Permission">
                    <template #body="slotProps">
                        <div @click="(permissionDialog = true),(data.role = slotProps.data)" v-if="slotProps.data.permissions.length == props.permissions.length" class="whitespace-nowrap cursor-pointer text-blue-600 dark:text-blue-400 font-bold underline">
                            All Permission
                        </div>   
                        <div @click="(permissionDialog = true),(data.role = slotProps.data)" v-else-if="slotProps.data.permissions.length > 0" class="whitespace-nowrap cursor-pointer text-blue-600 dark:text-blue-400 font-bold underline">
                            {{ slotProps.data.permissions.length }} Permission
                        </div>            
                        <div v-else>
                            {{ slotProps.data.permissions.length }} Permission
                        </div>                                    
                    </template>
                </Column>
                <Column field="created_at" header="Created"></Column>
                <Column field="updated_at" header="Updated"></Column>
                <Column :exportable="false" style="min-width: 12rem">
                    <template #body="slotProps">
                        <Button v-show="can(['update role'])" icon="pi pi-pencil" outlined rounded class="mr-2"  @click="
                                                    (data.editOpen = true),
                                                        (data.role = slotProps.data)" />
                        <Button v-show="can(['delete role'])" icon="pi pi-trash" outlined rounded severity="danger" @click="deleteDialog = true; data.role = slotProps.data" />
                    </template>
                </Column>
            </DataTable>

            <Dialog v-model:visible="deleteDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                <div class="flex items-center gap-4">
                    <i class="pi pi-exclamation-triangle !text-3xl" />
                    <span v-if="data.role"
                        >Are you sure you want to delete <b>{{ data.role.name }}</b
                        >?</span
                    >
                </div>
                <template #footer>
                    <Button label="No" icon="pi pi-times" text @click="deleteDialog = false" />
                    <Button label="Yes" icon="pi pi-check" @click="deleteData" />
                </template>
            </Dialog>

            <Dialog v-model:visible="permissionDialog" modal :header="'Permission ' + data.role?.name" :style="{ width: '50rem' }">
                <div class="grid grid-cols-2 sm:grid-cols-3">
                    <div
                        v-for="(permission, index) in data.role?.permissions"
                        :key="index"
                        class="flex justify-between w-full px-4 py-2"
                    >
                        {{ ++index + ". " + permission.name }}
                    </div>
                </div>
            </Dialog>
        </div>
    </app-layout>
</template>

<style scoped lang="scss">

</style>
