import { apiAxios } from "@/utils";
import { toCurrency } from "@/utils";

const endpoint = "/entries";

const EntryManager = {
	/**
	 * Get the dashboard data from the API
	 * @returns Promise
	 */
	getDashboardData: async () => {
		let { entries, total } = await apiAxios.get(endpoint);
		total = toCurrency(total).split(".");
		return { entries, total };
	},
	/**
	 * Get an entry by id from the API
	 * @param {number} entryId
	 * @returns
	 */
	getEntry: async entryId => {
		return apiAxios.get(`${endpoint}/${entryId}`);
	},
	/**
	 * Create a new entry
	 * @param {object} data
	 * @returns
	 */
	createEntry: async data => {
		return apiAxios.post(endpoint, data);
	},
	/**
	 * Update the given entry
	 * @param {number} entryId
	 * @param {object} data
	 * @returns
	 */
	updateEntry: async (entryId, data) => {
		return apiAxios.put(`${endpoint}/${entryId}`, data);
	},
	/**
	 * Delete the given entry
	 * @param {number} entryId
	 * @returns
	 */
	deleteEntry: async entryId => {
		return apiAxios.delete(`${endpoint}/${entryId}`);
	},
};

export default EntryManager;
