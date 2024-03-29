import { defineStore } from "pinia";
import { ref } from "vue";

export const useNotif = defineStore("notif", () => {
    const listNotif = ref([]);
    const loading = ref(false);
    function make(
        text,
        opt = {
            delay: 4000,
            type: "info",
        }
    ) {
        listNotif.value.push({
            text: text,
            option: opt,
        });
        setTimeout(() => {
            listNotif.value.splice(listNotif.value.length - 1, 1);
        }, opt?.delay);
    }

    return { listNotif, make, loading };
});
