const parseState = (state) => {
	return JSON.parse(JSON.stringify(state));
}

export const getItemById = (state, key, id) => {
	let parsedState = parseState(state);
	return parsedState[key][id] ? parsedState[key][id] : false;
}

export const getItems = (state, key) => {
	let parsedState = parseState(state);
	return parsedState[key] && parsedState[key].length ? parsedState[key] : false;
}