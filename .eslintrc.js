module.exports = {
	env: {
		browser: true,
		es2021: true,
	},
	extends: ["plugin:vue/essential", "airbnb-base"],
	parserOptions: {
		ecmaVersion: 12,
		sourceType: "module",
	},
	plugins: ["vue"],
	ignorePatterns: [
		"node_modules/*",
		"vendor/*",
		"public/js/*",
		"resources/js/vue-i18n-locales.generated.js",
	],
	rules: {
		indent: ["error", "tab"],
		"no-tabs": ["error", { allowIndentationTabs: true }],
		quotes: ["error", "double"],
		"no-console": "error",
		"vue/max-len": [
			"error",
			{
				code: 120,
				template: 2000,
				ignoreStrings: true,
				ignoreTemplateLiterals: true,
			},
		],
		"max-len": [
			"error",
			{
				code: 120,
			},
		],
		"no-plusplus": ["off"],
		"implicit-arrow-linebreak": ["off"],
		"function-paren-newline": ["off"],
		"vue/no-v-for-template-key": ["off"],
		"vue/no-v-model-argument": ["off"],
	},
	settings: {
		"import/resolver": {
			webpack: {
				config: "webpack.config.js",
			},
		},
	},
	globals: {
		describe: true,
		it: true,
		test: true,
		expect: true,
		route: true,
		Stripe: true,
		jest: true,
		beforeEach: true,
	},
};
