require("./bootstrap");
import Vue from "vue";
import AppLayout from "./layout/AppLayout.vue";
import { toCurrency, toFriendlyDate } from "./utils";

const appContainer = document.querySelector("#app");

Vue.filter("toCurrency", toCurrency);
Vue.filter("toFriendlyDate", toFriendlyDate);

if (appContainer) {
	new Vue({
		el: "#app",
		render: h => h(AppLayout),
	});
}
