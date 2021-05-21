<template>
	<div
		:class="
			`loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-${size} w-${size} ${color}`
		"
	></div>
</template>

<script>
export default {
	props: {
		size: {
			type: Number,
			default: 20,
		},
		color: {
			default: "blue",
		},
	},
};
</script>
<style>
.loader {
	-webkit-animation: spinner 0.5s linear infinite;
	-moz-animation: spinner 0.5s linear infinite;
	-o-animation: spinner 0.5s linear infinite;
	-ms-animation: spinner 0.5s linear infinite;
	animation: spinner 0.5s linear infinite;
}
.white {
	border-color: rgba(255, 255, 255, 0.2) !important;
	border-top-color: rgba(255, 255, 255, 0.9) !important;
}
.blue {
	border-top-color: rgba(70, 118, 226, 0.6) !important;
}
@-webkit-keyframes spinner {
	0% {
		-webkit-transform: rotate(0deg);
	}
	100% {
		-webkit-transform: rotate(360deg);
	}
}
@keyframes spinner {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
@-moz-keyframes spinner  /* Firefox */ {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
@-o-keyframes spinner  /* Opera */ {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
@-ms-keyframes spinner  /* IE */ {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}
</style>
