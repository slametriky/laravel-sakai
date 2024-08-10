<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
    },  
    {
        label: 'Master',
        items: [{ label: 'User', icon: 'pi pi-fw pi-user', to: '/user' }]
    },
    {
        label: 'Setting',
        items: [
            { label: 'Role', icon: 'pi pi-fw pi-id-card', to: '/role' },
            { label: 'Permission', icon: 'pi pi-fw pi-mobile', to: '/permission', class: 'rotated-icon' },
        ]
    },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
