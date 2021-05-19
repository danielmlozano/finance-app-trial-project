require("./bootstrap");
import Vue from "vue";
import AppLayout from "./layout/AppLayout.vue";

const appContainer = document.querySelector("#app");

if (appContainer) {
	new Vue({
		el: "#app",
		render: h => h(AppLayout),
	});
}
