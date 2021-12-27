<template>
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-height: 200px; z-index: 99999;">
        <div class="toast toast-show fade show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="flex-shrink-0">
                        <svg v-if="alert.success" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <svg v-else xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-exclamation-octagon-fill" viewBox="0 0 16 16">
                            <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0">{{ alert.success ? $t("Information saved.") : $t("Warning, check notification.") }}</h5>
                        <small class="ms-auto">{{ $t("Alert closing in") }} {{ this.closingIn }}s</small>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" @click="forceClose"></button>
                    </div>
                </div>
            </div>
            <div class="toast-body">
                {{ alert.message }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            timeOut: null,
            interval: null,
            closingIn: 5,
        }
    },
    props: ['alert'],
    methods: {
        forceClose() {
            clearTimeout(this.timeOut);
            this.$store.dispatch('clearAlert');
        }
    },
    created() {
        this.interval = setInterval(() => {
            this.closingIn = this.closingIn-1;
            if (this.closingIn == 0) {
                clearInterval(this.interval);
            }
        }, 1000)
        this.timeOut = setTimeout(() => {
            this.$store.dispatch('clearAlert');
            clearInterval(this.interval);
        }, 5000)
    }
}
</script>
