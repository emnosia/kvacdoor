$("#ajax-alert").click(function() {
    Swal.fire({
        title: "Submit your Github username",
        input: "text",
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: !0,
        confirmButtonText: "Look up",
        showLoaderOnConfirm: !0,
        preConfirm: function(t) {
            return fetch("//api.github.com/users/" + t).then(function(t) {
                if (!t.ok) throw new Error(t.statusText);
                return t.json()
            }).catch(function(t) {
                Swal.showValidationMessage("Request failed: " + t)
            })
        },
        allowOutsideClick: function() {
            Swal.isLoading()
        }
    }).then(function(t) {
        t.value && Swal.fire({
            title: t.value.login + "'s avatar",
            imageUrl: t.value.avatar_url
        })
    })
})