import { watch, computed } from 'vue';
import { useToast } from 'primevue/usetoast';
import { usePage } from '@inertiajs/vue3';

export function loadToast() {
    const toast = useToast();
    
    const flashMessage = computed(() => usePage().props.flash);

    watch(flashMessage, (newValue) => {
        if (newValue) {
            for (const [key, value] of Object.entries(newValue)) {
                if(newValue[key]) toast.add({severity:key, summary: 'Successful', detail: value, life: 3000});
            }    
        }
    }, { immediate: true });

    return {
        toast
    };
}
