<script>
	$(document).ready(function(){
		$("#tableData").DataTable();
		$("form").submit(function (e) { 
			e.preventDefault();
			
			const url = $(this).attr("action");
            const formData = new FormData(this);

            $.ajax({
                type: "post",
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                beforeSend: function () {
                    showLoad("modalForm", "modal");
                },
                success: function (response) {
                    closeLoad();
                    showAlert(response.result, response.title);
					if(response.result == "success"){
						setTimeout(() => {
							location.reload();
						}, 1500);
					}
                },
                error : function(textStatus){
                    console.log(textStatus);
                    closeLoad();
                    showAlert("error", "Terjadi kesalahan");
                }
            });
		});

		$("#btnModal").click(function(){
            $("#formModal")[0].reset();
			$("#id_ticket").val("");
			$("#it_support").removeAttr("readonly");
			$("#support").removeAttr("readonly");
        });
	})

	function edit(url){
		$.ajax({
			type: "get",
			url: url,
			contentType: false,
			processData: false,
			dataType: "JSON",
			beforeSend: function () {
				showLoad("secondCard");
			},
			success: function (response) {
				closeLoad();
				showAlert(response.result, response.title);
				if(response.result == "success"){
					$("#modalForm").modal("toggle");

                    const data = response.data;
                    $("#formModal")[0].reset();
                    $("#id_ticket").val(data.id);
                    $("#id_pengguna").val(data.id_pengguna);
                    $("#it_support").val(data.it_support);
					$("#it_support").attr("readonly", "readonly");
                    $("#title").val(data.title);
                    $("#description").val(data.description);
                    $("#status").val(data.status);
					$("#status").attr("readonly", "readonly");
                    $("#service_type").val(data.service_type);
                    $("#group_room").val(data.group_room);
                    $("#urgent_level").val(data.urgent_level);
                    $("#priority").val(data.priority);
				}
			},
			error : function(textStatus){
				console.log(textStatus);
				closeLoad();
				showAlert("error", "Terjadi kesalahan");
			}
		});
	}

	function showResolved(url){
		$.ajax({
			type: "get",
			url: url,
			contentType: false,
			processData: false,
			dataType: "JSON",
			beforeSend: function () {
				showLoad("secondCard");
				$("#cause").html("");
				$("#keterangan").html("");
			},
			success: function (response) {
				closeLoad();
				showAlert(response.result, response.title);
				if(response.result == "success"){
					$("#modalResolved").modal("toggle");

                    const data = response.data;
					$("#cause").html(data.cause);
					$("#keterangan").html(data.resolved_ket);
				}
			},
			error : function(textStatus){
				console.log(textStatus);
				closeLoad();
				showAlert("error", "Terjadi kesalahan");
			}
		});
	}

	function setStatus(url, status){
		const setUrl = url + "?status=" + status;
		if(status == "assign"){
			$("#formModal").attr("action", setUrl);
			$("#formModalResolved").modal("toggle");
		}
		else{
			$.ajax({
				type: "get",
				url: setUrl,
				contentType: false,
				processData: false,
				dataType: "JSON",
				beforeSend: function () {
					showLoad("secondCard");
				},
				success: function (response) {
					closeLoad();
					showAlert(response.result, response.title);
					if(response.result == "success"){
						setTimeout(() => {
							location.reload();
						} , 1500);
					}
				},
				error : function(textStatus){
					console.log(textStatus);
					closeLoad();
					showAlert("error", "Terjadi kesalahan");
				}
			});
		}
	}
</script>
