import Vue from "vue";

import Form from 'vform';

import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5';

Vue.component("form-button", Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.use(hljsVuePlugin);

Vue.component('skeleton', require('./components/partials/CustomSkeleton.vue').default);

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Toast
import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";
const toastOption = {
    position: "top-right",
    timeout: 5000,
    closeOnClick: false,
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    hideProgressBar: false,
    closeButton: "button",
    icon: "fas fa-rocket",
    rtl: false
}
Vue.use(Toast, toastOption);
// End

import Swal from "sweetalert2";
import axios from "axios";

window.swal = Swal;

window.Form = Form;


// rss to html form
if (document.getElementById("rssFeedForm"))
{
    const form = new Vue({
        el: "#rssFeedForm",
        data() {
            return {
                form: new Form({
                    url: "",
                    type: "grid",
                    column: 4,
                    row: 0,
                }),
                result: "",
                css: "",
                html: "",
                js: "",
                expanded: false,
                lang: "html"

            }
        },
        methods: {
            submitForm() {
                this.form.post("/admin/api/rss-feed-to-json")
                    .then(resp => {
                        return resp.data;
                    }).then(data => {
                        console.log(data);
                        if (data.status == "ok") {
                            this.$toast.success("HTML codes generated");
                            this.result = data.html;
                            this.html = data.html;
                            this.css = data.css;
                            this.js = data.js;
                        }
                        else {
                            this.$toast.error(data.msg);
                        }
                    }).catch(err => {
                        console.error(err.response.data);
                        if (err.response.status == 500) {
                            this.$toast.error(err.response.status+" error occured. Internal Server Error");
                        }
                    });
            },

            copyCode() {
                navigator.clipboard.writeText(this.result);
                this.$toast.success("Code copied to clipboard");
            },

            toggleCode(type) {
                if(type == "html") {
                    this.lang = "html";
                    this.result = this.html;
                }
                else if(type == "css"){
                    this.lang = "css";
                    this.result = this.css;
                }
                else if(type == "js") {
                    this.lang = "html";
                    this.result = this.js;
                }
            },
            openCarouselPrev() {
                if (this.form.type == "carousel") {
                    if (this.form.url != "") {
                        window.open(`/admin/carousel-preview?url=${this.form.url}&column=${this.form.column}&row=${this.form.row}`,"_blank");
                    }
                }
            }
        }
    })
}


// RSS Add Form

if (document.getElementById("rssAddPage"))
{
    const rssForm = new Vue({
        el: "#rssAddPage",
        data() {
            return {
                form: new Form({
                    url: "",
                })
            }
        },
        methods: {
            submitForm() {
                this.form.post("/admin/api/add-rss-url").then(resp => {
                    return resp.data;
                }).then(data => {
                    if (data.status == "ok") {
                        swal.fire("Success", data.msg, "success");
                        this.form.reset();
                    }

                }).catch(err => {
                    console.error(err.response.data);
                })
            }
        }
    });
}

// Rss List page
if (document.getElementById("rssListPage"))
{
    const rssList = new Vue({
        el: "#rssListPage",
        data() {
            return {
                urls: [],
                isLoading: true,
            }
        },
        methods: {
            getUrlList() {
                axios.get("/admin/api/get-rss-url-list").then(resp => {
                    return resp.data;
                }).then(data => {
                    this.urls = data;
                    this.isLoading = false;
                }).catch(err => {
                    console.error(err.response.data);
                })
            },
            deleteUrl(id, index) {
                swal.fire({
                    title: 'Are you sure you want to delete?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.post("/admin/api/delete-rss-url", {
                            urlId: id
                        }).then(resp => {
                            return resp.data;
                        }).then(data => {
                            if (data.status == "ok") {
                                this.$toast.error(data.msg);
                                this.urls.splice(index, 1);
                            }
                        }).catch(err => {
                            console.error(err.response.data);
                        })
                    }
                })
            }
        },
        mounted() {
            this.getUrlList();
        }
    });
}