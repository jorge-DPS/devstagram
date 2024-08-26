// import './bootstrap';
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone =  new Dropzone('#dropzone', {
    paramName: "archivo",
    dictDefaultMessage: "sube aqui tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            console.log(document.querySelector('[name="imagen"]').value);
            
            const imagenPublicada = {}
            imagenPublicada.size = 1234,
            imagenPublicada.name = document.querySelector('[name="imagen"]').value

            this.options.addedfile.call(this, imagenPublicada) // -> hace que se llame en automatico // bind hay que mandarlo a llamar la funcion
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`)

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete')
        }
    }
})



dropzone.on('success', function (archivo, response) {
    document.querySelector('[name="imagen"]').value = response.nombreImagen
    console.log(response.nombreImagen);
    
})

dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = ''
    
})