function showEditForm(formId) {

    let forms = document.querySelectorAll('.edit-form');
    forms.forEach(function(form) {
        form.style.display = 'none';
    });


    let formToShow = document.getElementById(formId);
    if (formToShow) {
        formToShow.style.display = 'block';
    }
}