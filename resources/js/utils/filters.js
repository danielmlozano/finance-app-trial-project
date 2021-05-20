import moment from "moment";

const toCurrency = value => {
	const formatter = new Intl.NumberFormat("en-US", {
		currency: "usd",
		minimumFractionDigits: 2,
		style: "currency",
	});
	return formatter.format(value);
};

const toFriendlyDate = value => {
	const today = moment().startOf("day");
	const yesterday = moment().subtract(1, "days");
	const date = moment(value);

	if (date.isSame(today, "d")) {
		return "Today";
	}
	if (date.isSame(yesterday, "d")) {
		return "Yesterday";
	}
	return moment(date).format("ddd, DD MMM");
};

export { toCurrency, toFriendlyDate };
