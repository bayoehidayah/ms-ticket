<script>
	$(document).ready(function(){
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
                    showLoad("loginForm");
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
	})
</script>
