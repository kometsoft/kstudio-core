const theme = {
	primary: '#4f46e5',
	secondary: '#4f46e5',
	success: '#16a34a',
	info: '#0ea5e9',
	warning: '#fbbf24',
	danger: '#dc2626',
	white: '#fff',
	'gray-100': '#f3f4f6',
	'gray-200': '#e5e7eb',
	'gray-300': '#d1d5db',
	'gray-400': '#9ca3af',
	'gray-500': '#6b7280',
	'gray-600': '#4b5563',
	'gray-700': '#374151',
	'gray-800': '#1f2937',
	'gray-900': '#111827',
	black: '#000',
}

// Add theme to the window object
window.theme = theme

toggleFullscreen = function () {
	!!document.fullscreenElement ? document.exitFullscreen() : document.body.requestFullscreen()
}

deleteRow = function (id, route) {
	var result = confirm("Are you sure you want to delete this record?");
	if (result) {
		axios.delete(route)
			.then(function(response){
				window.LaravelDataTables[id].ajax.reload(null, false);
			})
			.catch(function(error){
				console.log(error);
			});
	}
}