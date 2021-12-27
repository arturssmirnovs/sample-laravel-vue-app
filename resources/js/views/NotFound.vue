<template>
    <main id="content" role="main">
        <!-- Content -->
        <div class="container text-center">
            <div class="mb-3">
                <img class="img-fluid" src="/assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 30rem;">
            </div>

            <div class="mb-4">
                <p class="fs-4 mb-0">Oops! Looks like you followed a bad link.</p>
                <p class="fs-4">If you think this is a problem with us, please <a class="link" href="#">tell us</a>.</p>
            </div>

            <router-link :to="{name: 'Home', params: {locale: $i18n.locale}}" class="btn btn-primary">{{ $t("Go back home") }}</router-link>
        </div>
        <!-- End Content -->
    </main>
</template>
