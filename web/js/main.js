$(document).ready(function() {
    $('#source-selector').on('change', function() {
        let selectedSource = $(this).val();
        $("#ajax-content").hide();
        $("#loading-spinner").show();

        if (selectedSource !== '') {
            $(document).ready(function () {
                $.ajax({
                    url: "http://test-work/wallet/" + selectedSource,
                    method: "GET",
                    dataType: "html",
                    success: function (data) {
                        $("#loading-spinner").hide();
                        $("#ajax-content").show().html(data);
                    },
                    error: function (error) {
                        console.error("Error:", error);
                    }
                });
            });
        }
    });

    $('body').on('click', '#convert', function() {
        console.log(123);
        let rate1 = $('select[name="currency1"]').val();
        let rate2 = $('select[name="currency2"]').val();
        let wallet_sum = $('#wallet_sum').val();

        if (rate2 != 0) {
            let result = wallet_sum * ( rate1 / rate2);
            $('#result').val(result.toFixed(2)); // Отображаем результат с двумя знаками после запятой
        } else {
            alert('Ошибка: Деление на ноль.');
        }
    });
});
