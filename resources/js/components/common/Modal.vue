<template>
	<transition leave-active-class="duration-200">
		<div
			v-show="show"
			class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
			scroll-region
		>
			<transition
				enter-active-class="ease-out duration-300"
				enter-from-class="opacity-0"
				enter-to-class="opacity-100"
				leave-active-class="ease-in duration-200"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<div
					v-show="show"
					class="fixed inset-0 transform transition-all"
					@click="close"
				>
					<div class="absolute inset-0 bg-gray-500 opacity-75"></div>
				</div>
			</transition>

			<transition
				enter-active-class="ease-out duration-300"
				enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
				enter-to-class="opacity-100 translate-y-0 sm:scale-100"
				leave-active-class="ease-in duration-200"
				leave-from-class="opacity-100 translate-y-0 sm:scale-100"
				leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
			>
				<div
					v-show="show"
					class="mb-6 bg-white rounded-lg overflow-x-hidden overflow-y-scroll shadow-xl transform transition-all sm:w-full sm:mx-auto p-8"
					:class="maxWidthClass"
				>
					<slot v-if="show"></slot>
				</div>
			</transition>
		</div>
	</transition>
</template>

<script>
export default {
	props: {
		show: {
			default: false,
		},
		maxWidth: {
			default: "2xl",
		},
		closeable: {
			default: true,
		},
	},
	watch: {
		show: {
			immediate: true,
			handler(show) {
				if (show) {
					document.body.style.overflow = "hidden";
				} else {
					document.body.style.overflow = null;
				}
			},
		},
	},
	methods: {
		close() {
			if (this.closeable) {
				this.$emit("close");
			}
		},
		closeOnEscape(e) {
			if (this.closeable) {
				if (e.key === "Escape" && this.show) {
					close();
				}
			}
		},

		mounted() {
			document.addEventListener("keydown", this.closeOnEscape);
		},

		beforeDestroy() {
			document.removeEventListener("keydown", this.closeOnEscape);
		},
	},
	computed: {
		maxWidthClass() {
			return {
				sm: "sm:max-w-sm",
				md: "sm:max-w-md",
				lg: "sm:max-w-lg",
				xl: "sm:max-w-xl",
				"2xl": "sm:max-w-2xl",
			}[this.maxWidth];
		},
	},
};
</script>

<style></style>
