<template>
	<div id="finance-app">
		<app-header @user="setUser" />
		<div class="mb-12 py-6 bg-gray-800">
			<div class="container mx-auto flex px-8">
				<div class="my-auto text-white flex flex-grow items-center">
					<h1 class="md:block hidden mr-4 text-2xl font-bold">
						Your Balance
					</h1>

					<div class="flex flex-row">
						<app-button
							@click.native="addNewEntry"
							:disabled="csvImport.rows > 0"
						>
							Add entry
						</app-button>
						<app-button
							:disabled="csvImport.rows > 0"
							@click.native="showCsvImport = true"
						>
							Import csv
						</app-button>
					</div>
				</div>
				<div
					class="my-auto text-right font-bold text-xs uppercase tracking-tight leading-7 text-gray-400"
				>
					Total Balance
					<span class="block text-3xl font-normal text-green-500">
						{{ total.amount }}.<span class="text-xl">{{
							total.cents
						}}</span>
					</span>
				</div>
			</div>
		</div>

		<div class="container mx-auto px-8">
			<alert
				class="my-4"
				type="warning"
				:spinner="true"
				v-if="csvImport.rows > 0"
				>We're importing {{ csvImport.rows }} balance entries. Sit
				tight!</alert
			>

			<alert class="my-4" type="success" v-if="csvImport.success"
				>Done! We've imported your CSV file successfully.</alert
			>

			<entries
				v-if="entries"
				:data="entries"
				@refresh="getData()"
				:rebuild="rebuildList"
			/>
		</div>
		<modal :show="entryInModal" @close="entryInModal = null">
			<div>
				<h2 class="font-bold text-black text-lg">
					Add Balance Entry
				</h2>
				<entry-form
					class="my-8 pb-40"
					action="create"
					@cancel="entryInModal = null"
					@success="getData()"
				/>
			</div>
		</modal>

		<modal :show="showCsvImport" @close="showCsvImport = false">
			<div>
				<h2 class="font-bold text-black text-lg">
					Import Balance Entries
				</h2>
				<csv-import
					class="my-8"
					v-if="showCsvImport"
					@cancel="showCsvImport = false"
					@success="handleCsvUploaded"
				/>
			</div>
		</modal>
	</div>
</template>

<script>
import EntryManager from "@/managers/entry";
import {
	Alert,
	AppHeader,
	AppButton,
	Modal,
	Spinner,
} from "@/components/common";
import { Entries, EntryForm, CsvImport } from "@/components/entries";
export default {
	components: {
		Alert,
		EntryForm,
		AppHeader,
		AppButton,
		Entries,
		Modal,
		Spinner,
		CsvImport,
	},
	data() {
		return {
			emptyEntry: {
				label: null,
				amount: null,
				date: null,
			},
			entryInModal: null,
			total: {
				amount: 0,
				cents: 0,
			},
			entries: null,
			loading: true,
			showCsvImport: false,
			user: null,
			rebuildList: true,
			csvImport: {
				rows: 0,
				success: false,
			},
			page: 1,
		};
	},
	methods: {
		addNewEntry() {
			this.entryInModal = this.emptyEntry;
		},
		async getData(paginate = false) {
			if (!paginate) {
				this.page = Math.min(this.page, 1);
			}
			this.loading = true;
			this.entryInModal = null;
			try {
				const { entries, total } = await EntryManager.getDashboardData(
					this.page,
				);
				this.total = {
					amount: total[0],
					cents: total[1],
				};
				this.rebuildList = !paginate;
				this.entries = entries.data;
				if (entries.next_page_url) {
					this.page++;
				} else {
					this.page = 0;
				}
			} catch (e) {}
			this.loading = false;
		},
		setUser(user) {
			this.user = user;
			Echo.channel(`u${this.user.id}-notifications`).listen(
				"CsvProcessed",
				this.onImportSuccess,
			);
		},
		async onImportSuccess() {
			await this.getData();
			this.csvImport.rows = 0;
			this.csvImport.success = true;
			setTimeout(() => (this.csvImport.success = false), 10000);
		},
		handleCsvUploaded(imported_rows) {
			this.csvImport.rows = imported_rows;
			this.showCsvImport = false;
		},
		infiniteScroll() {
			window.addEventListener("scroll", async e => {
				if (this.loading || this.page < 1) {
					return;
				}
				if (
					window.innerHeight + window.scrollY >=
					document.body.offsetHeight
				) {
					await this.getData(true);
				}
			});
		},
	},
	async mounted() {
		await this.getData();
		this.infiniteScroll();
	},
};
</script>

<style>
.datetime-picker .year-month-wrapper,
.datetime-picker button,
.datetime-picker .activePort {
	background-color: #4676e2 !important;
	color: #fff !important;
}
.datetime-picker .days,
.datetime-picker .port:hover {
	color: #4676e2 !important;
}
#tj-datetime-input,
#tj-datetime-input:focus {
	height: 100%;
	width: 100%;
	outline: none;
}
</style>
