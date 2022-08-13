const overlayEl =
    '<div class="overlay dark loader-spin"><i class="fas fa-3x fa-spinner fa-spin text-default"></i></div>';

/*
 * overlay load on the element
 * type -> card|modal
 * parentTypeID -> card id|modal id
 */
function showLoad(parentTypeID, type = "card") {
    if (type == "card") {
        $("#" + parentTypeID).append(overlayEl);
    } else if (type == "modal") {
        $("#" + parentTypeID + " .modal-dialog").append(overlayEl);
    }

    //Check if theme using dark mode or not
    if($("body").hasClass("dark-mode") === false){
        $("#loader").removeClass("dark");
    }
}

// Untuk semua class
function showLoad2(parentTypeClass, type = "card") {
    if (type == "card") {
        $("." + parentTypeClass).append(overlayEl);
    } else if (type == "modal") {
        $("." + parentTypeClass + " .modal-dialog").append(overlayEl);
    }

    //Check if theme using dark mode or not
    if($("body").hasClass("dark-mode") === false){
        $(".loader-spin").removeClass("dark");
    }
}

function closeLoad() {
    $(".loader-spin").remove();
}

toastr.options = {
    "newestOnTop": true,
    "progressBar": true,
    "hideDuration": "1000",
    "positionClass": "toast-bottom-right",
};

/*
 * give a warning toast at the bottom right in the window
 * type -> error|info|success|warning
 */
function showAlert(type, msg) {
    if (type == "success") {
        toastr.success(msg);
    } else if (type == "info") {
        toastr.info(msg);
    } else if (type == "warning") {
        toastr.warning(msg);
    } else if (type == "error") {
        toastr.error(msg);
    }
}

//number_format in php
function formatCurrency(amount, decimalCount = 2, decimal = ",", thousands = ".") {
    try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
}


function deleteData(url, forceDelete = 0) {
    const title = forceDelete ? "Apakah anda yakin ingin menghapus ini secara permanen?<br/>Data tidak dapat dikembalikan" : "Apakah anda yakin ingin menghapus ini?";

    swal.fire({
        title: "Perhatian!",
        html: title,
        icon: "warning",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json()
                })
                .then(data => {
                    if (data.result == "error") {
                        swal.showValidationMessage(data.title);
                    }
                })
                .catch(error => {
                    console.error(error);
                    swal.showValidationMessage("Terjadi kesalahan dalam menghapus data");
                })
        },
        allowOutsideClick: () => !swal.isLoading()
    }).then((result) => {
        if (result.value) {
            swal.fire({
                title: "Berhasil!",
                text: forceDelete ? "Data telah berhasil dihapus secara permanen" : "Data telah berhasil dihapus",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
                showCancelButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    if (table !== undefined) {
                        table.ajax.reload(null, false);
                    } else {
                        location.reload();
                    }
                }
            });
        }
    })
}

function restore(url) {
    swal.fire({
        title: "Informasi!",
        html: "Apakah anda yakin ingin mengembalikan ini?",
        icon: "info",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json()
                })
                .then(data => {
                    if (data.result == "error") {
                        swal.showValidationMessage(data.title);
                    }
                })
                .catch(error => {
                    console.error(error);
                    swal.showValidationMessage("Terjadi kesalahan dalam mengembalikan data");
                })
        },
        allowOutsideClick: () => !swal.isLoading()
    }).then((result) => {
        if (result.value) {
            swal.fire({
                title: "Berhasil!",
                text: "Data telah berhasil dikembalikan",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
                showCancelButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    if (table !== undefined) {
                        table.ajax.reload(null, false);
                    } else {
                        location.reload();
                    }
                }
            });
        }
    })
}

$.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
    console.error(message);
    showAlert("error", message);
};
