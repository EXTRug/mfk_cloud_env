var quill = new Quill('#editor_area', {
    theme: 'snow',
    modules: {
        toolbar: {
            container: '#toolbar1' // Attach toolbar1 to the first editor
        }
    }
});

var quill2 = new Quill('#editor_area_2', {
    theme: 'snow',
    modules: {
        toolbar: {
            container: '#toolbar2' // Attach toolbar2 to the second editor
        }
    }
});
