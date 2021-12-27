<template>
    <div>
        <!-- ========== FOOTER ========== -->
        <footer class="bg-light">
            <div class="container pb-1 pb-lg-7">
                <div class="row content-space-t-2">
                    <div class="col-lg-3 mb-7 mb-lg-0">
                        <!-- Logo -->
                        <div class="mb-5">
                            <a class="navbar-brand" href="./index.html" aria-label="Space">
                                <img class="navbar-brand-logo" src="/assets/svg/logos/logo.svg" alt="Image Description">
                            </a>
                        </div>
                        <!-- End Logo -->

                        <!-- List -->
                        <ul class="list-unstyled list-py-1">
                            <li><a class="link-sm link-secondary" href="#"><i class="bi-geo-alt-fill me-1"></i> 153 Williamson Plaza, Maggieberg</a></li>
                            <li><a class="link-sm link-secondary" href="tel:1-062-109-9222"><i class="bi-telephone-inbound-fill me-1"></i> +1 (062) 109-9222</a></li>
                        </ul>
                        <!-- End List -->

                    </div>
                    <!-- End Col -->

                    <div class="col-sm mb-7 mb-sm-0">
                        <h5 class="mb-3">Company</h5>

                        <!-- List -->
                        <ul class="list-unstyled list-py-1 mb-0">
                            <li><a class="link-sm link-secondary" href="#">About</a></li>
                            <li><a class="link-sm link-secondary" href="#">Careers <span class="badge bg-warning text-dark rounded-pill ms-1">We're hiring</span></a></li>
                            <li><a class="link-sm link-secondary" href="#">Blog</a></li>
                            <li><a class="link-sm link-secondary" href="#">Customers <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
                            <li><a class="link-sm link-secondary" href="#">Hire us</a></li>
                        </ul>
                        <!-- End List -->
                    </div>
                    <!-- End Col -->

                    <div class="col-sm mb-7 mb-sm-0">
                        <h5 class="mb-3">Features</h5>

                        <!-- List -->
                        <ul class="list-unstyled list-py-1 mb-0">
                            <li><a class="link-sm link-secondary" href="#">Press <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
                            <li><a class="link-sm link-secondary" href="#">Release Notes</a></li>
                            <li><a class="link-sm link-secondary" href="#">Integrations</a></li>
                            <li><a class="link-sm link-secondary" href="#">Pricing</a></li>
                        </ul>
                        <!-- End List -->
                    </div>
                    <!-- End Col -->

                    <div class="col-sm">
                        <h5 class="mb-3">Documentation</h5>

                        <!-- List -->
                        <ul class="list-unstyled list-py-1 mb-0">
                            <li><a class="link-sm link-secondary" href="#">Support</a></li>
                            <li><a class="link-sm link-secondary" href="#">Docs</a></li>
                            <li><a class="link-sm link-secondary" href="#">Status</a></li>
                            <li><a class="link-sm link-secondary" href="#">API Reference</a></li>
                            <li><a class="link-sm link-secondary" href="#">Tech Requirements</a></li>
                        </ul>
                        <!-- End List -->
                    </div>
                    <!-- End Col -->

                    <div class="col-sm">
                        <h5 class="mb-3">Resources</h5>

                        <!-- List -->
                        <ul class="list-unstyled list-py-1 mb-5">
                            <li><a class="link-sm link-secondary" href="#"><i class="bi-question-circle-fill me-1"></i> Help</a></li>
                            <li><a class="link-sm link-secondary" href="#"><i class="bi-person-circle me-1"></i> Your Account</a></li>
                        </ul>
                        <!-- End List -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="border-top my-7"></div>

                <div class="row mb-7">
                    <div class="col-sm mb-3 mb-sm-0">
                        <!-- Socials -->
                        <ul class="list-inline list-separator mb-0">
                            <li class="list-inline-item">
                                <a class="text-body" href="#">Privacy &amp; Policy</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-body" href="#">Terms</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-body" href="#">Site Map</a>
                            </li>
                        </ul>
                        <!-- End Socials -->
                    </div>

                    <div class="col-sm-auto">
                        <!-- Socials -->
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                    <i class="bi-facebook"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                    <i class="bi-google"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                    <i class="bi-twitter"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a class="btn btn-soft-secondary btn-xs btn-icon" href="#">
                                    <i class="bi-github"></i>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-soft-secondary btn-xs dropdown-toggle" id="footerSelectLanguage" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                        <span class="d-flex align-items-center">
                                            <img class="avatar avatar-xss avatar-circle me-2" :src="'/assets/flags/1x1/'+$i18n.locale+'.svg'" alt="Image description" width="16"/>
                                            <span>{{ $i18n.locale.toUpperCase() }}</span>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="footerSelectLanguage">
                                        <a class="dropdown-item d-flex align-items-center active" href="#" v-for="lang in locales" :key="lang" @click="setLocale(lang)">
                                            <img class="avatar avatar-xss avatar-circle me-2" :src="'/assets/flags/1x1/'+lang+'.svg'" alt="Image description" width="16"/>
                                            <span>{{ lang.toUpperCase() }}</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="w-md-85 text-lg-center mx-lg-auto">
                    <p class="text-muted small">&copy; Front. 2021 Htmlstream. All rights reserved.</p>
                    <p class="text-muted small">When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.</p>
                </div>
            </div>
        </footer>

        <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: visible;">
            <i class="bi-chevron-up"></i>
        </a>
    </div>
</template>

<script>
import TranslationService from '@/js/services/translationService';
import { mapGetters } from 'vuex';

export default {
    data: () => ({
        showLangauges: false,
        showMenu: false
    }),
    methods: {
        setLocale(lang) {
            this.$i18n.locale = lang;
            TranslationService.messages({lang: this.$i18n.locale}).then((res) => {
                const { data } = res.data;
                const params = {...this.$route.params};
                this.showLangauges = false;
                params.locale = this.$i18n.locale;
                this.$i18n.setLocaleMessage(this.$i18n.locale, data);
                this.$router.push({name: this.$route.name, params: params});
            })
        }
    },
    computed: {
        ...mapGetters(['locales', 'isAuthenticated', 'user'])
    }
}
</script>
