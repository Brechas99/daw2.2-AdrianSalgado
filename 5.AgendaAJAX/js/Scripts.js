window.onload = inicializar;



// ---------- VARIABLES GLOBALES ----------

var divCategoriasDatos;
var divPersonasDatos;
var inputCategoriaNombre;
var inputPersonaNombre;
var inputPersonaApellidos;
var inputPersonaTelefono;
var inputPersonaCategoriaId;



// ---------- VARIOS DE BASE/UTILIDADES ----------

function notificarUsuario(texto) {
    alert(texto);
}

function llamadaAjax(url, parametros, manejadorOK, manejadorError) {
    var request = new XMLHttpRequest();

    request.open("POST", url);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    request.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (request.status == 200) {
                manejadorOK(request.responseText);
            } else {
                if (manejadorError != null) manejadorError(request.responseText);
            }
        }
    };

    request.send(parametros);
}

function extraerId(texto) {
    return texto.split('-')[1];
}

function objetoAParametrosParaRequest(objeto) {
    return new URLSearchParams(objeto).toString();
}

function debug() {
}



// ---------- MANEJADORES DE EVENTOS / COMUNICACIÓN CON PHP ----------

function inicializar() {
    divCategoriasDatos = document.getElementById("categoriasDatos");
    divPersonasDatos = document.getElementById("personasDatos");

    inputCategoriaNombre = document.getElementById("categoriaNombre");
    inputPersonaNombre = document.getElementById("personaNombre");
    inputPersonaApellidos = document.getElementById("personaApellidos");
    inputPersonaTelefono = document.getElementById("personaTelefono");
    inputPersonaCategoriaId = document.getElementById("personaCategoriaId");



    document.getElementById('btnCategoriaCrear').addEventListener('click', clickCategoriaCrear);
    document.getElementById('btnPersonaCrear').addEventListener('click', clickPersonaCrear);


    llamadaAjax("CategoriaObtenerTodas.php", "",
        function(texto) {
            var categorias = JSON.parse(texto);

            for (var i=0; i<categorias.length; i++) {
                domCategoriaInsertar(categorias[i]);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al cargar categorías al inicializar: " + texto);
        }
    );

    llamadaAjax("PersonaObtenerTodas.php", "",
        function(texto) {
            var personas = JSON.parse(texto);

            for (var i=0; i<personas.length; i++) {
                domPersonaInsertar(personas[i]);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al cargar personas al inicializar: " + texto);
        }
    );
}

function clickCategoriaCrear() {
    inputCategoriaNombre.disabled = true;

    llamadaAjax("CategoriaCrear.php", "nombre=" + inputCategoriaNombre.value,
        function(texto) {
            var categoria = JSON.parse(texto);

            domCategoriaInsertar(categoria, true);

            inputCategoriaNombre.value = "";
            inputCategoriaNombre.disabled = false;
        },
        function(texto) {
            notificarUsuario("Error Ajax al crear: " + texto);
            inputCategoriaNombre.disabled = false;
        }
    );
}

function clickPersonaCrear() {
    inputPersonaNombre.disabled = true;
    inputPersonaApellidos.disabled = true;
    inputPersonaTelefono.disabled = true;
    inputPersonaCategoriaId.disabled = true;

    llamadaAjax("PersonaCrear.php", "nombre="+inputPersonaNombre.value + "&apellidos="+inputPersonaApellidos.value + "&telefono="+inputPersonaTelefono.value + "&categoriaId="+inputPersonaCategoriaId.value,
        function(texto) {
            var Persona = JSON.parse(texto);

            domPersonaInsertar(Persona, true);

            inputPersonaNombre.value = "";
            inputPersonaNombre.disabled = false;
            inputPersonaApellidos.value = "";
            inputPersonaApellidos.disabled = false;
            inputPersonaTelefono.value = "";
            inputPersonaTelefono.disabled = false;
            inputPersonaCategoriaId.value = "";
            inputPersonaCategoriaId.disabled = false;
        },
        function(texto) {
            notificarUsuario("Error Ajax al crear: " + texto);
            inputPersonaNombre.disabled = false;
        }
    );
}

function blurCategoriaModificar(input) {
    let divCategoria = input.parentElement.parentElement;
    let categoria = domCategoriaDivAObjeto(divCategoria);

    llamadaAjax("CategoriaActualizar.php", objetoAParametrosParaRequest(categoria),
        function(texto) {
            if (texto != "null") {
                categoria = JSON.parse(texto);
                domCategoriaModificar(categoria);
            } else {
                notificarUsuario("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al modificar: " + texto);
        }
    );
}

function blurPersonaModificar(input) {
    let divPersona = input.parentElement.parentElement;
    let persona = domPersonaDivAObjeto(divPersona);

    llamadaAjax("PersonaActualizar.php", objetoAParametrosParaRequest(persona),
        function(texto) {
            if (texto != "null") {
                persona = JSON.parse(texto);
                domPersonaModificar(persona);
            } else {
                notificarUsuario("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al modificar: " + texto);
        }
    );
}

function clickCategoriaEliminar(id) {
    llamadaAjax("CategoriaEliminar.php", "id="+id,
        function(texto) {
            var operacionOK = JSON.parse(texto);
            if (operacionOK) {
                domCategoriaEliminar(id);
            } else {
                notificarUsuario("Error Ajax al eliminar: " + texto);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al eliminar: " + texto);
        }
    );
}

function clickPersonaEliminar(id) {
    llamadaAjax("PersonaEliminar.php", "id="+id,
        function(texto) {
            var operacionOK = JSON.parse(texto);
            if (operacionOK) {
                domPersonaEliminar(id);
            } else {
                notificarUsuario("Error Ajax al eliminar: " + texto);
            }
        },
        function(texto) {
            notificarUsuario("Error Ajax al eliminar: " + texto);
        }
    );
}



// ---------- GESTIÓN DEL DOM ----------

function domCrearDivInputText(textoValue, codigoOnblur) {
    let div = document.createElement("div");
        let input = document.createElement("input");
                input.setAttribute("type", "text");
                input.setAttribute("value", textoValue);
                input.setAttribute("onblur", codigoOnblur + " return false;");
    div.appendChild(input);

    return div;
}

function domCrearDivImg(urlSrc, codigoOnclick) {
    let div = document.createElement("div");
        let img = document.createElement("img");
                img.setAttribute("src", urlSrc);
                img.setAttribute("onclick", codigoOnclick + " return false;");
    div.appendChild(img);

    return div;
}



function domCategoriaObjetoADiv(categoria) {
    let div = document.createElement("div");
            div.setAttribute("id", "categoria-" + categoria.id);
    div.appendChild(domCrearDivInputText(categoria.nombre, "blurCategoriaModificar(this);"));
    div.appendChild(domCrearDivImg("img/Eliminar.png", "clickCategoriaEliminar(" + categoria.id + ");"));

    return div;
}

function domCategoriaObtenerDiv(pos) {
    return divCategoriasDatos.children[pos];
}

function domCategoriaDivAObjeto(div) {
    return {
        "id": extraerId(div.id),
        "nombre": div.children[0].children[0].value,
    };
}

function domCategoriaObtenerObjeto(pos) {
    let divCategoria = domCategoriaObtenerDiv(pos);
    return domCategoriaDivAObjeto(divCategoria);
}

function domCategoriaEjecutarInsercion(pos, categoria) {
    let divReferencia = domCategoriaObtenerDiv(pos);
    let divNuevo = domCategoriaObjetoADiv(categoria);

    divCategoriasDatos.insertBefore(divNuevo, divReferencia);
}

function domCategoriaInsertar(categoriaNueva, enOrden=false) {
    if (enOrden) {
        for (let pos = 0; pos < divCategoriasDatos.children.length; pos++) {
            let categoriaActual = domCategoriaObtenerObjeto(pos);

            if (categoriaNueva.nombre.localeCompare(categoriaActual.nombre) == -1) {
                domCategoriaEjecutarInsercion(pos, categoriaNueva);
                return;
            }
        }
    }

    domCategoriaEjecutarInsercion(divCategoriasDatos.children.length, categoriaNueva);
}

function domCategoriaLocalizarPosicion(id) {
    var trs = divCategoriasDatos.children;

    for (var pos=0; pos < divCategoriasDatos.children.length; pos++) {
        let categoriaActual = domCategoriaObtenerObjeto(pos);

        if (categoriaActual.id == id) return (pos);
    }

    return -1;
}

function domCategoriaEliminar(id) {
    domCategoriaObtenerDiv(domCategoriaLocalizarPosicion(id)).remove();
}

function domCategoriaModificar(categoria) {
    domCategoriaEliminar(categoria.id);
    domCategoriaInsertar(categoria, true);
}



function domPersonaObjetoADiv(persona) {
    let div = document.createElement("div");
            div.setAttribute("id", "persona-" + persona.id);
    div.appendChild(domCrearDivInputText(persona.estrella, "blurPersonaModificar(this);"));
    div.appendChild(domCrearDivInputText(persona.nombre, "blurPersonaModificar(this);"));
    div.appendChild(domCrearDivInputText(persona.apellidos, "blurPersonaModificar(this);"));
    div.appendChild(domCrearDivInputText(persona.telefono, "blurPersonaModificar(this);"));
    div.appendChild(domCrearDivInputText(persona.categoriaId, "blurPersonaModificar(this);"));
    div.appendChild(domCrearDivImg("img/Eliminar.png", "clickPersonaEliminar(" + persona.id + ");"));

    return div;
}

function domPersonaObtenerDiv(pos) {
    return divPersonasDatos.children[pos];
}

function domPersonaDivAObjeto(div) {
    return {
        "id": extraerId(div.id),
        "nombre": div.children[1].children[0].value,
        "apellidos": div.children[2].children[0].value,
        "telefono": div.children[3].children[0].value,
        "estrella": div.children[0].children[0].value,
        "categoriaId": div.children[4].children[0].value,
    }
}

function domPersonaObtenerObjeto(pos) {
    let divPersona = domPersonaObtenerDiv(pos);
    return domPersonaDivAObjeto(divPersona);
}

function domPersonaEjecutarInsercion(pos, persona) {
    let divReferencia = domPersonaObtenerDiv(pos);
    let divNuevo = domPersonaObjetoADiv(persona);

    divPersonasDatos.insertBefore(divNuevo, divReferencia);
}

function domPersonaInsertar(personaNueva, enOrden=false) {
    if (enOrden) {
        for (let pos = 0; pos < divPersonasDatos.children.length; pos++) {
            let personaActual = domPersonaObtenerObjeto(pos);

            let cadenaActual = personaActual.nombre + personaActual.apellidos;
            let cadenaNueva = personaNueva.nombre + personaNueva.apellidos;

            if (cadenaNueva.localeCompare(cadenaActual) == -1) {
                domPersonaEjecutarInsercion(pos, personaNueva);
                return;
            }
        }
    }

    domPersonaEjecutarInsercion(divPersonasDatos.children.length, personaNueva);
}

function domPersonaLocalizarPosicion(id) {
    var trs = divPersonasDatos.children;

    for (var pos=0; pos < divPersonasDatos.children.length; pos++) {
        let personaActual = domPersonaObtenerObjeto(pos);

        if (personaActual.id == id) return (pos);
    }

    return -1;
}

function domPersonaEliminar(id) {
    domPersonaObtenerDiv(domPersonaLocalizarPosicion(id)).remove();
}

function domPersonaModificar(persona) {
    domPersonaEliminar(persona.id);
    domPersonaInsertar(persona, true);
}