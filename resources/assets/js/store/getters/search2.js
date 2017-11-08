export const results2 = (state) => {
			return state.results.map(item => {
				item.url = 'https://ru.wikipedia.org/wiki/' + item.title
				return item
			})
		}