<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="http://35.173.186.107/lib/js/croppr.min.js"></script>
    <script src="http://35.173.186.107/lib/js/bootstrap.min.js"></script>
    <script src="http://35.173.186.107/lib/js/tesseract.min.js"></script>
    <link rel="stylesheet" href="http://35.173.186.107/lib/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://35.173.186.107/lib/css/croppr.min.css">

    <input type="text">
</head>
<body>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Comenzar ahora
        </button>


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <!-- Scrollable modal -->
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Encontrar url de facturacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <h2>1 Introduce tu imagen</h2>
                <input type="file" id="image">

                <h2>2 Recorta</h2>
                <div id="editor"></div>

                <h2>3 Previsualiza el resultado</h2>
                <canvas id="preview"></canvas>

            


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="img-to-txt" type="button" class="btn btn-primary">Analizar</button>
            </div>
            </div>
        </div>
        </div>













    
</body>
<footer>
    <script>
        let load = () => {
            const inputImage = document.querySelector('#image');
            const editor = document.querySelector('#editor');
            const miCanvas = document.querySelector('#preview');
            const contexto = miCanvas.getContext('2d');
            let urlImage = undefined;

            inputImage.addEventListener('change', abrirEditor, false);


            // const worker = new Tesseract.TesseractWorker()
            let imgElement = document.getElementById('imageSrc');

            

            function abrirEditor(e) {
                urlImage = URL.createObjectURL(e.target.files[0]);
                editor.innerHTML = '';
                let cropprImg = document.createElement('img');
                cropprImg.setAttribute('id', 'croppr');
                editor.appendChild(cropprImg);
                contexto.clearRect(0, 0, miCanvas.width, miCanvas.height);
                document.querySelector('#croppr').setAttribute('src', urlImage);
                new Croppr('#croppr', {
                    aspectRatio: 'free',
                    startSize: [70, 10],
                    onCropEnd: recortarImagen
                })
            }
            function recortarImagen(data) {
                const inicioX = data.x;
                const inicioY = data.y;
                const nuevoAncho = data.width;
                const nuevaAltura = data.height;
                const zoom = 1;
                var imageBuffer

                let imagenEn64 = '';
                miCanvas.width = nuevoAncho;
                miCanvas.height = nuevaAltura;
                let miNuevaImagenTemp = new Image();
                miNuevaImagenTemp.onload = function() {
                    contexto.drawImage(miNuevaImagenTemp, inicioX, inicioY, nuevoAncho * zoom, nuevaAltura * zoom, 0, 0, nuevoAncho, nuevaAltura);
                    imagenEn64 = miCanvas.toDataURL("image/jpeg");
                    // imgElement.src = imagenEn64;
                    // imgElement.style.display = 'none'
                    // document.querySelector('#base64').textContent = imagenEn64;


                }
                miNuevaImagenTemp.src = urlImage
                console.log("Analizando texto")

            
                document.getElementById("img-to-txt").addEventListener("click", function(){
                    let btn = this;
                    btn.disable = true;
                    let tesseractSettings = {
                        lang: 'spa',
                        tessedit_char_whitelist: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ.'
                    };
                    Tesseract.recognize(miCanvas, tesseractSettings).progress(function(p){
                        // console.log(p.status)
                    }).then(function(result){
                        // console.log(result);
                        console.log(result.text);
                       
                        if(confirm("Se detectó: "+result.text+"¿Aceptar?")){ 
                            fetch('http://35.173.186.107/services/createfactura.php/?captura='+miNuevaImagenTemp+'&url='+result.text+'&numeroTicket=123ABCD&idUsuario=1', {
                                method: 'GET',
                            }).then(
                                response => response
                            ).then(
                                response => {
                                    window.location = "./invitado?request_description=1";
                                }
                            ).catch(
                                error => console.log(error)
                            )
                            var myModalEl = document.getElementById('staticBackdrop');
                            var modal = bootstrap.Modal.getInstance(myModalEl)
                            modal.hide();    
                            
                        }
                    }).finally(function(){
                        btn.disable = false;
                        });
                }, false);




            }
            let misEventosBtn = document.getElementById("misEventos");
                misEventosBtn.addEventListener("click", () => {
                  
                })
            



        }
        addEventListener("DOMContentLoaded", load)

    </script>

</footer>
</html>

