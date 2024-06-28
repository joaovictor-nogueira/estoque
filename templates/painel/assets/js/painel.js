/* CODIGO DE BARRAS camera - ADICIONAR */

document.addEventListener("DOMContentLoaded", function() {
    const btnCamera = document.getElementById('btn_camera');
    const btnLeitor = document.getElementById('btn_leitor');
    const inputCodigoBarra = document.getElementById('codigo_barra');
    const interactive = document.getElementById('interactive');
    const usbMessage = document.getElementById('usb-message');

    btnCamera.addEventListener('click', function() {
        if (Quagga.initialized) {
            Quagga.stop();
            Quagga.initialized = false;
            interactive.style.display = 'none';
        } else {
            interactive.style.display = 'block';
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#interactive')    // Or '#yourElement' (optional)
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_93_reader"]
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return
                }
                console.log("Initialization finished. Ready to start");
                Quagga.start();
                Quagga.initialized = true;
            });
        }
    });

    Quagga.onDetected(function(data) {
        inputCodigoBarra.value = data.codeResult.code;
        inputCodigoBarra.readOnly = true;
        Quagga.stop();
        Quagga.initialized = false;
        interactive.style.display = 'none';
    });

    btnLeitor.addEventListener('click', function() {
        usbMessage.style.display = 'block';
    });

    document.getElementById('btn_submit').addEventListener('click', function() {
        document.getElementById('formulario').submit();
    });

    // Leitor de código de barras USB
    let barcode = '';
    let lastKeyTime = Date.now();

    document.addEventListener('keypress', function(e) {
        if (e.key !== 'Enter') {
            const currentTime = Date.now();

            if (currentTime - lastKeyTime > 100) {
                barcode = '';
            }

            barcode += e.key;
            lastKeyTime = currentTime;
        } else {
            if (barcode) {
                inputCodigoBarra.value = barcode;
                inputCodigoBarra.readOnly = true;
                barcode = '';
                usbMessage.style.display = 'none';
            }
        }
    });
});

/* CONFIRMAÇÃO SE USUARIO CADASTROU CODIGO DE BARRAS - MODAL */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const codigoBarraInput = document.getElementById('codigo_barra');
    const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const confirmButton = document.getElementById('confirmSubmit');
    
    form.addEventListener('submit', function (event) {
        if (!codigoBarraInput.value) {
            event.preventDefault();
            confirmModal.show();
        }
    });

    confirmButton.addEventListener('click', function () {
        confirmModal.hide();
        form.submit();
    });
});


/* BUSCAR ITEM POR QR CODE */

document.addEventListener("DOMContentLoaded", function() {
    const btnCamera = document.getElementById('btn_camera_busca');
    const btnLeitor = document.getElementById('btn_leitor_busca');
    const formCodigoBarra = document.getElementById('form_codigo_barra_busca');
    const inputCodigoBarra = document.getElementById('codigo_barra_busca');
    const interactive = document.getElementById('interactive_busca'); 
    const usbMessage = document.getElementById('usb_message_busca');

    btnCamera.addEventListener('click', function() {
        if (Quagga.initialized) {
            Quagga.stop();
            Quagga.initialized = false;
            interactive.style.display = 'none';
        } else {
            interactive.style.display = 'block';
            Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: interactive 
                },
                decoder: {
                    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader", "2of5_reader", "code_93_reader"]
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                console.log("Initialization finished. Ready to start");
                Quagga.start();
                Quagga.initialized = true;
            });
        }
    });

    Quagga.onDetected(function(data) {
        inputCodigoBarra.value = data.codeResult.code;
        inputCodigoBarra.readOnly = true;
        Quagga.stop();
        Quagga.initialized = false;
        interactive.style.display = 'none';

        // Preencher o formulário e submeter
        formCodigoBarra.submit();
    });

    btnLeitor.addEventListener('click', function() {
        usbMessage.style.display = 'block';
    });

    // Leitor de código de barras USB
    let barcode = '';
    let lastKeyTime = Date.now();

    document.addEventListener('keypress', function(e) {
        if (e.key !== 'Enter') {
            const currentTime = Date.now();

            if (currentTime - lastKeyTime > 100) {
                barcode = '';
            }

            barcode += e.key;
            lastKeyTime = currentTime;
        } else {
            if (barcode) {
                inputCodigoBarra.value = barcode;
                inputCodigoBarra.readOnly = true;
                barcode = '';
                usbMessage.style.display = 'none';

                // Preencher o formulário e submeter
                formCodigoBarra.submit();
            }
        }
    });
});
