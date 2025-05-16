$(document).ready(function () {
	$("#tableUSer").DataTable({
		// rowReorder: {
		//     selector: 'td:nth-child(2)'
		// },
		responsive: true,
	});
	$("#tableInventory").DataTable({
		// rowReorder: {
		//     selector: 'td:nth-child(2)'
		// },
		columnDefs: [{ targets: [0], visible: false, searchable: false }],
		responsive: true,
		initComplete: function () {
			this.api()
				.columns([3])
				.every(function () {
					var column = this;
					var select = $(
						'<select class="form-control form-control-sm bg-default" ><option value="" disabled selected>Filter Nama Barang</option><option value=""></option></select>'
					)
						.appendTo($("#nama_barang"))
						.on("change", function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append(
								'<option value="' + d + '">' + d.toUpperCase() + "</option>"
							);
						});
				});
			this.api()
				.columns([6])
				.every(function () {
					var column = this;
					var select = $(
						'<select class="form-control form-control-sm bg-default" ><option value="" disabled selected>Filter Suplyer</option><option value=""></option></select>'
					)
						.appendTo($("#kategori"))
						.on("change", function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());

							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append(
								'<option value="' + d + '">' + d.toUpperCase() + "</option>"
							);
						});
				});
		},
	});
	$("#tableKeuangan").DataTable({
		columnDefs: [{ targets: [0], visible: false, searchable: false }],
		order: [[0, "desc"]],
		responsive: true,
		initComplete: function () {
			this.api()
				.columns([2])
				.every(function () {
					var column = this;
					var select = $(
						'<select class="form-control form-control-sm bg-default" ><option value="" disabled selected>Filter Karyawan</option><option value=""></option></select>'
					)
						.appendTo($("#karyawan"))
						.on("change", function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append(
								'<option value="' + d + '">' + d.toUpperCase() + "</option>"
							);
						});
				});
			this.api()
				.columns([3])
				.every(function () {
					var column = this;
					var select = $(
						'<select class="form-control form-control-sm bg-default" ><option value="" disabled selected>Filter Kategori</option><option value=""></option></select>'
					)
						.appendTo($("#kategori"))
						.on("change", function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());

							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append(
								'<option value="' + d + '">' + d.toUpperCase() + "</option>"
							);
						});
				});
			this.api()
				.columns([1])
				.every(function () {
					var column = this;
					var select = $(
						'<select class="form-control form-control-sm bg-default" ><option value="" disabled selected>Filter Status</option><option value=""></option></select>'
					)
						.appendTo($("#status"))
						.on("change", function () {
							var val = $.fn.dataTable.util.escapeRegex($(this).val());
							column.search(val ? "^" + val + "$" : "", true, false).draw();
						});

					column
						.data()
						.unique()
						.sort()
						.each(function (d, j) {
							select.append(
								'<option value="' + d + '">' + d.toUpperCase() + "</option>"
							);
						});
				});
		},

		// initComplete: function () {
		// 	this.api()
		// 		.columns()
		// 		.every(function () {
		// 			let column = this;

		// 			// Create select element
		// 			let select = document.createElement("select");

		// 			select.add(new Option(""));
		// 			column.footer().replaceChildren(select);

		// 			// Apply listener for user change in value
		// 			select.addEventListener("change", function () {
		// 				var val = DataTable.util.escapeRegex(select.value);
		// 				column.search(val ? "^" + val + "$" : "", true, false).draw();
		// 			});

		// 			// Add list of options
		// 			column
		// 				.data()
		// 				.unique()
		// 				.sort()
		// 				.each(function (d, j) {
		// 					select.add(new Option(d));
		// 				});
		// 		});
		// },
	});
	$("#tableOnModal").DataTable({
		// rowReorder: {
		//     selector: 'td:nth-child(2)'
		// },
		responsive: true,
		// "lengthChange": false,
		// info: false,
		// paging: false
	});
	$("#tableOnModalPelanggan").DataTable({
		// rowReorder: {
		//     selector: 'td:nth-child(2)'
		// },
		responsive: true,
		// "lengthChange": false,
		// info: false,
		// paging: false
	});
});
