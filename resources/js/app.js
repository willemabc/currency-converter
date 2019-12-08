require('./bootstrap');

$(document).ready(function() {
	let home = $('#container-home');
	if (home) {
		let cardSelection = $('#card-selection');
		let currency = $('#currency');
		let amount = $('#amount');
		let convert = $('#convert');

		let cardResults = $('#card-results');
		let results = $('#results');

		cardResults.hide();
		results.hide();

		currency.on('change', function() {
			// if currency selection changes, hide results card
			cardResults.hide();
		});

		amount.on('keydown', function() {
			// if amount changes, hide results card
			cardResults.hide();
		});

		amount.on('change', function() {
			// just replace comma with dot to help our Dutch friends
			amount.val(amount.val().replace(',', '.'));

			// check if value is numeric, else reset to 1
			if (!$.isNumeric(amount.val())) amount.val('1.00');

			// round to 2 digits
			amount.val(parseFloat(amount.val()).toFixed(2));
		});

		convert.on('click', function() {
			results.hide();
			cardResults.show();

			// get rates with ajax
			$.post('/api/rates', {
                currency: currency.val()
            }, function(data) {
				let tableBody = cardResults.find('table tbody');
				tableBody.empty();

				$.each(data, function(index, row) {
					let rate = parseFloat(row.rate);
					let calculation = rate * parseFloat(amount.val());

					tableBody.append('<tr><td class="col-8">' + row.name + ' (' + row.code + ')</td><td class="col-4">' + calculation.toFixed(2) + '</td></tr>');
				})

				results.show();
            },'json');
		});
	}
});
