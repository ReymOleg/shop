export const results = (state) => {
		return state.results.map(item => {
			item.url = 'https://ru.wikipedia.org/wiki/' + item.title
			return item
		})
	}

export const test = (state) => {
		return state.results
	}