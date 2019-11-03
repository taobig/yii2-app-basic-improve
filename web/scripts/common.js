/*global console*/
$(function () {
    // var a = 1111;
    // console.log(a);

    if(false) {
        var formData = new FormData();
        $form.find("input[type=file]").each(function (i, element) {
            if ($(element)[0].files.length > 0) {
                formData.append("file_" + file_index, $(element)[0].files[0]);
            }
        });
        formData.append("input_name", $("input[name=input_name]:checked").val());
        $.ajax({
            url: $form.attr('action'),
            type: 'post',
            data: formData,
            cache: false,
            dataType: 'json',
            headers: {
                'X-RESPONSE-TYPE': 'json'
            },
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            context: this,
            beforeSend: function (xhr) {
                SimpleLoading.start('box');
            }
        }).done(function (data, textStatus, jqXHR) {
            if (data.status !== 0) {
                alert(data.message);
                SimpleLoading.stop();
            } else {
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            SimpleLoading.stop();
            alert('系统异常，请重试');
        }).always(function () {
        });
    }

    //post File
    //post form
    //post json
});