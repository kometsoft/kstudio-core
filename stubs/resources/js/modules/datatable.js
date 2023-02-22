import 'datatables.net-bs5/js/dataTables.bootstrap5.min.js'
import 'datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js'
import 'datatables.net-buttons/js/buttons.colVis.min.js'
import 'datatables.net-select-bs5/js/select.bootstrap5.min.js'
import '../../../public/vendor/datatables/buttons.server-side.js'

$.fn.dataTable.Buttons.defaults.dom.button.className = 'btn btn-sm btn-outline-primary'

$.extend($.fn.dataTable.defaults, {
	dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"<"table-responsive"tr>>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
	autoWidth: false,
	pagingType: 'full_numbers',
	pageLength: 10,
	language: {
		processing: '<div class="spinner-border text-primary" role="status"></div>',
		paginate: {
			first: '<i class="ti ti-chevrons-left text-sm fs-6"></i>',
			previous: '<i class="ti ti-chevron-left text-sm fs-6"></i>',
			next: '<i class="ti ti-chevron-right text-sm fs-6"></i>',
			last: '<i class="ti ti-chevrons-right text-sm fs-6"></i>',
		},
		// url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/German.json"
	},
	initComplete: function (settings, json) {
		console.log('DT Loaded')
	},
})
