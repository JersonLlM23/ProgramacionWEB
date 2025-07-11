// 1. Función para validar nombre corto
function validarNombreCorto(input) {
    const mensaje = document.getElementById('mensajeNombre');
    if (input.value.length > 5) {
        mensaje.textContent = "Nombre demasiado largo, por favor, usa un nombre más corto";
        mensaje.className = "text-danger";
    } else {
        mensaje.textContent = "";
    }
}
 

// 2. Función para validar correo del observatorio
function validarCorreoObservatorio(input) {
    const mensaje = document.getElementById('mensajeCorreo');
    if (input.value.includes('@espe.edu.ec')) {
        mensaje.textContent = "✅ Correo válido del observatorio";
        mensaje.className = "text-success";
    }
}

 

// 3. Función para clasificar astrónomo por edad
function clasificarAstronomo(input) {
    const edad = parseInt(input.value);
    const mensaje = document.getElementById('mensajeEdad');
    
    if (edad <= 19) {
        mensaje.textContent = "🌟 Aún estás en formación";
        mensaje.className = "text-warning";
    } else if (edad >= 20 && edad <= 60) {
        mensaje.textContent = "🔭 Astrónomo activo";
        mensaje.className = "text-success";
    } else if (edad > 60) {
        mensaje.textContent = "👨‍🏫 Astrónomo veterano";
        mensaje.className = "text-primary";
    }
}

 
function validarContrasenaSegura(input) {
    const mensaje = document.getElementById('mensajeContrasena');
    if (input.value.length < 6 && input.value.length > 0) {
        mensaje.textContent = "⚠️ Contraseña insegura";
        mensaje.className = "text-danger";
    } else {
        mensaje.textContent = "";
    }
}

 
function calcularAniosObservatorio(input) {
    const fechaIngreso = new Date(input.value);
    const fechaActual = new Date();
    const diferencia = fechaActual - fechaIngreso;
    const anios = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365));
    
    const mensaje = document.getElementById('mensajeFecha');
    if (anios >= 0) {
        mensaje.textContent = `📅 Llevas ${anios} año(s) en el observatorio`;
        mensaje.className = "text-info";
    }
}
 
function validarHoraObservacion(input) {
    const hora = input.value;
    const mensaje = document.getElementById('mensajeHora');
    
    if (hora >= "20:00") {
        mensaje.textContent = "🌙 Hora ideal para observación";
        mensaje.className = "text-success";
    } else{
        mensaje.textContent = "☀️ La observación puede ser difícil a esa hora";
        mensaje.className = "text-warning";
    }
}
 
function mostrarNombreArchivo(input) {
    const mensaje = document.getElementById('mensajeArchivo');
    if (input.files.length > 0) {
        mensaje.textContent = `📄 Archivo: ${input.files[0].name}`;
        mensaje.className = "text-info";
    }
}

 

// 8. Función para cambiar color según experiencia
function cambiarColorExperiencia(input) {
    const valor = parseInt(input.value);
    const valorDiv = document.getElementById('valorExperiencia');
    
    valorDiv.textContent = valor;
    
    if (valor > 70) {
        valorDiv.style.color = "green";
        valorDiv.style.fontWeight = "bold";
    } else if (valor < 30) {
        valorDiv.style.color = "red";
        valorDiv.style.fontWeight = "bold";
    } else {
        valorDiv.style.color = "orange";
        valorDiv.style.fontWeight = "normal";
    }
}
 
function mostrarNivelExperiencia(input) {
    const valor = parseInt(input.value);
    const mensaje = document.getElementById('mensajeExperiencia');
    
    if (valor < 30) {
        mensaje.textContent = "📚 Básico";
        mensaje.className = "text-warning";
    } else if (valor <= 70) {
        mensaje.textContent = "🔬 Intermedio";
        mensaje.className = "text-info";
    } else {
        mensaje.textContent = "🏆 Avanzado";
        mensaje.className = "text-success";
    }
}

// 9. Función para cambiar color de ilustración
function cambiarColorIlustracion(input) {
    const ilustracion = document.getElementById('ilustracionTelescopio');
    ilustracion.style.backgroundColor = input.value;
}

// 10. Función para validar solo números en teléfono
function validarSoloNumeros(input) {
    const valor = input.value;
    const soloNumeros = valor.replace(/[^0-9]/g, '');
    
    if (valor !== soloNumeros) {
        input.value = soloNumeros;
        document.getElementById('mensajeTelefono').textContent = "⚠️ Solo se permiten números";
        document.getElementById('mensajeTelefono').className = "text-warning";
    } else {
        document.getElementById('mensajeTelefono').textContent = "";
    }
}

// Función para validar longitud del teléfono
function validarLongitudTelefono(input) {
    const mensaje = document.getElementById('mensajeTelefono');
    if (input.value.length < 10 && input.value.length > 0) {
        mensaje.textContent = "⚠️ Debe tener al menos 10 dígitos";
        mensaje.className = "text-warning";
    } else if (input.value.length >= 10) {
        mensaje.textContent = "✅ Número válido";
        mensaje.className = "text-success";
    }
}

// 11. Función para mostrar preview del link
function mostrarPreviewLink(input) {
    const mensaje = document.getElementById('mensajeWeb');
    if (input.value.includes('http')) {
        mensaje.innerHTML = `🔗 <a href="${input.value}" target="_blank">Preview del enlace</a>`;
        mensaje.className = "text-info";
    }
}

 
 

 
function mostrarDescripcionRol(radio) {
    const descripciones = {
        'Investigador': 'Líder de proyectos científicos y publicaciones',
        'Técnico': 'Especialista en equipos y mantenimiento',
        'Becario': 'Estudiante en formación investigativa'
    };
    
    document.getElementById('descripcionRol').textContent = 
        `👔 ${descripciones[radio.value]}`;
}

 
function cambiarInfoUniverso(select) {
    const info = {
        'Via Lactea': 'Nuestra galaxia espiral con 100-400 mil millones de estrellas',
        'Andromeda': 'Galaxia vecina que colisionará con la Vía Láctea en 4.5 mil millones de años',
        'Sombrero': 'Galaxia famosa por su forma distintiva de sombrero mexicano'
    };
    
    const infoDiv = document.getElementById('infoUniverso');
    if (select.value) {
        infoDiv.textContent = `🌌 ${info[select.value]}`;
        infoDiv.className = "text-info mt-2";
    } else {
        infoDiv.textContent = "";
    }
}

 
function mostrarContadorCaracteres(textarea) {
    const contador = document.getElementById('contadorCaracteres');
    contador.style.display = 'block';
    actualizarContador(textarea);
}

// Función para actualizar contador
function actualizarContador(textarea) {
    const contador = document.getElementById('contadorCaracteres');
    contador.textContent = `Caracteres: ${textarea.value.length}`;
}

// Función para validar biografía vacía
function validarBiografiaVacia(textarea) {
    const mensaje = document.getElementById('mensajeBiografia');
    if (textarea.value.trim() === "") {
        mensaje.textContent = "✨ ¡Comparte tu pasión por la astronomía!";
        mensaje.className = "text-info";
    } else {
        mensaje.textContent = "";
    }
}

 
function analizarPerfil() {
    const nombre = document.getElementById('nombreCorto').value;
    const correo = document.getElementById('correoInstitucional').value;
    const edad = document.getElementById('edad').value;
    const experiencia = document.getElementById('experiencia').value;
    const contrasena = document.getElementById('contrasena').value;
    const mensaje = document.getElementById('mensajeAnalisis');
    
    if (nombre && correo && edad && contrasena && experiencia > 40) {
        mensaje.textContent = "🌟 Perfil completo para ser astrónomo líder";
        mensaje.className = "text-success";
    } else {
        mensaje.textContent = "📝 Completa más campos para mejorar tu perfil";
        mensaje.className = "text-warning";
    }
}

 
function cambiarColorBoton(button) {
    button.style.backgroundColor = "#0056b3";
}

function restaurarColorBoton(button) {
    button.style.backgroundColor = "";
}

 
function validarFormularioCompleto(event) {
    const campos = ['nombreCorto', 'correoInstitucional', 'edad', 'contrasena'];
    let errores = [];
    
    campos.forEach(campo => {
        const input = document.getElementById(campo);
        if (!input || !input.value.trim()) {
            errores.push(`El campo ${campo} es requerido`);
        }
    });
    
    // Validaciones específicas
    const edad = document.getElementById('edad').value;
    if (edad && edad < 20) {
        errores.push('La edad mínima es 20 años');
    }
    
    const correo = document.getElementById('correoInstitucional').value;
    if (correo && !correo.includes('@espe.edu.ec')) {
        errores.push('El correo debe ser institucional @espe.edu.ec');
    }
    
    const contrasena = document.getElementById('contrasena').value;
    if (contrasena && contrasena.length < 6) {
        errores.push('La contraseña debe tener al menos 6 caracteres');
    }
    
    if (errores.length > 0) {
        event.preventDefault();
        alert('Errores encontrados:\n' + errores.join('\n'));
    } else {
        event.preventDefault(); // Prevenir envío real
        alert('¡Formulario enviado exitosamente! 🚀');
    }
}

// 12. Función para mostrar información de áreas
function mostrarInfoArea(checkbox) {
    const infoDiv = document.getElementById('infoAreas');
    const areas = {
        'Astrofísica': 'Estudio de las propiedades físicas de los objetos celestes',
        'Exoplanetas': 'Búsqueda y caracterización de planetas fuera del sistema solar',
        'Cosmología': 'Estudio del origen y evolución del universo'
    };
    
    const seleccionadas = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
        .map(cb => areas[cb.value])
        .filter(Boolean);
    
    infoDiv.innerHTML = seleccionadas.length > 0 ? 
        `📖 ${seleccionadas.join(' | ')}` : '';
}


