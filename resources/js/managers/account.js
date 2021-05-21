import { apiAxios } from "@/utils";

const AccountManager = {
	me: () => {
		return apiAxios.get("account/me");
	},
};

export default AccountManager;
