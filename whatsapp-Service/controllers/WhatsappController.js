const PacienteModel = require("../models/PacienteModel");
const CitaModel = require("../models/CitaModel");

const sesiones = {};

// Helper para programar/renovar la expiración por inactividad
const resetearTimerInactividad = (from, minutos = 60) => {
  if (sesiones[from]?.timer) {
    clearTimeout(sesiones[from].timer);
  }

  if (sesiones[from]) {
    sesiones[from].timer = setTimeout(
      () => {
        delete sesiones[from];
      },
      minutos * 60 * 1000,
    );
  }
};

// Valida si el texto ingresado es un saludo de inicio
const esSaludoInicio = (texto) => {
  const limpio = texto.toLowerCase().trim();
  const saludos = [
    "hola",
    "buenas",
    "buenos dias",
    "buenos días",
    "buenas tardes",
    "buenas noches",
    "hola buenas",
    "hola buenos dias",
    "hola buenas tardes",
    "hola buenas noches",
    "inicio",
    "empezar",
    "menu",
    "menú",
  ];
  return saludos.includes(limpio);
};

// Valida celular colombiano
const esTelefonoValido = (telefonoStr) => {
  const limpio = telefonoStr.replace(/\D/g, "");
  const regexCelularCol = /^3\d{9}$/;
  return regexCelularCol.test(limpio) ? limpio : null;
};

// Calcula la hora de finalización
const calcularHoraFinal = (horaInicioStr, duracionMinutos = 30) => {
  const [hh, mm] = horaInicioStr.split(":").map(Number);
  let totalMinutos = hh * 60 + mm + duracionMinutos;

  const finHH = String(Math.floor(totalMinutos / 60)).padStart(2, "0");
  const finMM = String(totalMinutos % 60).padStart(2, "0");

  return `${finHH}:${finMM}:00`;
};

// Normaliza hora según jornada laboral
const normalizarHora = (horaTexto, duracionMinutos = 30) => {
  const texto = horaTexto.trim().toLowerCase();

  const match = texto.match(/^(\d{1,2})(?::(\d{2}))?\s*(am|pm)?$/);
  if (!match) return null;

  let hours = parseInt(match[1], 10);
  let minutes = match[2] ? parseInt(match[2], 10) : 0;
  const ampm = match[3];

  if (hours < 0 || hours > 24 || minutes < 0 || minutes > 59) return null;

  if (ampm) {
    if (ampm === "pm" && hours < 12) hours += 12;
    if (ampm === "am" && hours === 12) hours = 0;
  } else {
    if (hours >= 1 && hours <= 6) {
      hours += 12;
    }
  }

  const minutosTotales = hours * 60 + minutes;

  const inicioManana = 8 * 60;
  const finManana = 12 * 60;
  const inicioTarde = 14 * 60;
  const finTarde = 18 * 60;

  const enJornadaManana =
    minutosTotales >= inicioManana &&
    minutosTotales + duracionMinutos <= finManana;
  const enJornadaTarde =
    minutosTotales >= inicioTarde &&
    minutosTotales + duracionMinutos <= finTarde;

  if (!enJornadaManana && !enJornadaTarde) {
    return null;
  }

  const hh = String(hours).padStart(2, "0");
  const mm = String(minutes).padStart(2, "0");

  return `${hh}:${mm}:00`;
};

// Helper para cálculo de meses
const NOMBRES_MESES = [
  "Enero",
  "Febrero",
  "Marzo",
  "Abril",
  "Mayo",
  "Junio",
  "Julio",
  "Agosto",
  "Septiembre",
  "Octubre",
  "Noviembre",
  "Diciembre",
];

const obtenerInfoMeses = () => {
  const hoy = new Date();
  const anoActual = hoy.getFullYear();
  const mesActualIdx = hoy.getMonth();
  const diaHoy = hoy.getDate();

  const ultimoDiaMesActual = new Date(anoActual, mesActualIdx + 1, 0).getDate();
  const fechaSigMes = new Date(anoActual, mesActualIdx + 1, 1);
  const anoSigMes = fechaSigMes.getFullYear();
  const mesSigIdx = fechaSigMes.getMonth();
  const ultimoDiaMesSig = new Date(anoSigMes, mesSigIdx + 1, 0).getDate();

  return {
    diaHoy,
    anoActual,
    mesActualIdx,
    nombreMesActual: NOMBRES_MESES[mesActualIdx],
    ultimoDiaMesActual,
    esUltimoDia: diaHoy === ultimoDiaMesActual,
    esPenultimoDia: diaHoy === ultimoDiaMesActual - 1,
    anoSigMes,
    mesSigIdx,
    nombreMesSig: NOMBRES_MESES[mesSigIdx],
    ultimoDiaMesSig,
  };
};

class WhatsappController {
  static async procesarMensaje(baileysService, msg) {
    const from = msg.key.remoteJid;
    const esMensajePropio = msg.key.fromMe;
    const texto = (
      msg.message?.conversation ||
      msg.message?.extendedTextMessage?.text ||
      ""
    ).trim();
    const textoMin = texto.toLowerCase();

    // -------------------------------------------------------------
    // COMANDO DE REACTIVACIÓN (ASESOR O PACIENTE)
    // -------------------------------------------------------------
    const comandosReactivar = ["!bot", "!activar", "!salir", "bot"];
    if (comandosReactivar.includes(textoMin)) {
      if (sesiones[from]?.timer) clearTimeout(sesiones[from].timer);
      delete sesiones[from];
      return await baileysService.enviarTexto(
        from,
        "🤖 *El asistente virtual ha sido reactivado.* Escribe *hola* para iniciar nuevamente.",
      );
    }

    // Ignorar mensajes salientes de la clínica que no sean comandos
    if (esMensajePropio) {
      if (sesiones[from] && sesiones[from].paso === "ASESOR") {
        resetearTimerInactividad(from, 60);
      }
      return;
    }

    // -------------------------------------------------------------
    // BLOQUEO CUANDO EL PACIENTE ESTÁ EN ATENCIÓN HUMANA (ASESOR)
    // -------------------------------------------------------------
    if (sesiones[from] && sesiones[from].paso === "ASESOR") {
      resetearTimerInactividad(from, 60);
      return;
    }

    // -------------------------------------------------------------
    // COMANDO PARA CANCELAR FLUJO ACTUAL
    // -------------------------------------------------------------
    if (textoMin === "cancelar") {
      if (sesiones[from]?.timer) clearTimeout(sesiones[from].timer);
      delete sesiones[from];
      return await baileysService.enviarTexto(
        from,
        "❌ Proceso cancelado. Escribe *hola* cuando quieras regresar al menú.",
      );
    }

    // -------------------------------------------------------------
    // INICIO DE SESIÓN O DETECCIÓN DE SALUDO
    // -------------------------------------------------------------
    if (!sesiones[from] || esSaludoInicio(texto)) {
      sesiones[from] = { paso: "MENU_PRINCIPAL" };
      return await baileysService.enviarTexto(
        from,
        "✨ *¡Hola! Te damos la bienvenida al Consultorio Odontológico Dr. Felipe Cabrera.* 🦷👋\n\n" +
          "¿En qué podemos ayudarte hoy?\n\n" +
          "1️⃣ *Agendar cita*\n" +
          "2️⃣ *Cancelar cita*\n" +
          "9️⃣ *Hablar con un asesor*\n\n" +
          "_(Escribe *cancelar* en cualquier momento para salir)_",
      );
    }

    const estado = sesiones[from];

    switch (estado.paso) {
      case "MENU_PRINCIPAL":
        if (texto === "1") {
          estado.accion = "AGENDAR";
          await baileysService.enviarTexto(
            from,
            "📌 *Importante:* Los datos a diligenciar deben ser del *paciente que asistirá a la cita* (ej. si agendó para un hijo/a, ingresar los datos del menor).\n\n" +
              "1️⃣ *De acuerdo, continuar*\n" +
              "0️⃣ *Volver al menú anterior*",
          );
          estado.paso = "ADVERTENCIA_DATOS_PACIENTE";
        } else if (texto === "2") {
          estado.accion = "CANCELAR_CITA";
          await baileysService.enviarTexto(
            from,
            "📄 Por favor ingresa tu *número de documento*:\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "CANCELAR_BUSCAR_PACIENTE";
        } else if (texto === "9") {
          return await WhatsappController.derivarAAsesor(
            baileysService,
            from,
            estado,
          );
        } else {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Opción inválida. Elige:\n1️⃣ Agendar cita\n2️⃣ Cancelar cita\n9️⃣ Hablar con asesor",
          );
        }
        break;

      case "ADVERTENCIA_DATOS_PACIENTE":
        if (texto === "0")
          return await WhatsappController.regresarAMenu(
            baileysService,
            from,
            estado,
          );
        if (texto === "1") {
          await baileysService.enviarTexto(
            from,
            "📌 Selecciona el servicio que necesitas:\n\n" +
              "1️⃣ *Consulta General* (30 min)\n" +
              "2️⃣ *Cirugía de Cordales* (1 hora)\n\n" +
              "0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_TIPO_CONSULTA";
        } else {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Selecciona *1️⃣ De acuerdo* para continuar o *0️⃣ Volver*:",
          );
        }
        break;

      // -------------------------------------------------------------
      // FLUJO DE CANCELACIÓN DE CITAS
      // -------------------------------------------------------------
      case "CANCELAR_BUSCAR_PACIENTE":
        if (texto === "0")
          return await WhatsappController.regresarAMenu(
            baileysService,
            from,
            estado,
          );

        const pacienteCanc = await PacienteModel.buscarPorDocumento(texto);

        if (!pacienteCanc) {
          delete sesiones[from];
          return await baileysService.enviarTexto(
            from,
            "❌ No encontramos ningún paciente registrado con ese documento. Escribe *hola* para intentar de nuevo.",
          );
        }

        const citas = await CitaModel.buscarCitasActivasPorPaciente(
          pacienteCanc.id,
        );

        if (citas.length === 0) {
          delete sesiones[from];
          return await baileysService.enviarTexto(
            from,
            `👋 Hola *${pacienteCanc.nombre}*, no tienes citas pendientes.`,
          );
        }

        estado.citasDisponibles = citas;
        let listaCitas = `📋 *Citas de ${pacienteCanc.nombre}:*\n\n`;

        citas.forEach((c, i) => {
          listaCitas += `${i + 1}️⃣ *Fecha:* ${c.fecha} | *Hora:* ${c.hora.substring(0, 5)}\n   *Motivo:* ${c.motivo}\n\n`;
        });

        listaCitas +=
          "Responde con el número de la cita que deseas cancelar:\n\n0️⃣ *Volver atrás*";

        await baileysService.enviarTexto(from, listaCitas);
        estado.paso = "CONFIRMAR_CANCELACION_CITA";
        break;

      case "CONFIRMAR_CANCELACION_CITA":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "📄 Ingresa tu *número de documento*:\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "CANCELAR_BUSCAR_PACIENTE";
          return;
        }

        const indice = parseInt(texto, 10) - 1;

        if (isNaN(indice) || !estado.citasDisponibles[indice]) {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Opción no válida. Elige un número de la lista o *0️⃣ Volver*:",
          );
        }

        const citaACancelar = estado.citasDisponibles[indice];
        await CitaModel.cancelarCita(citaACancelar.id);

        await baileysService.enviarTexto(
          from,
          `✅ *Cita cancelada con éxito.*\n\nLa reserva del día *${citaACancelar.fecha}* a las *${citaACancelar.hora.substring(0, 5)}* ha sido cancelada.`,
        );

        delete sesiones[from];
        return;

      // -------------------------------------------------------------
      // FLUJO DE AGENDAMIENTO DE CITAS
      // -------------------------------------------------------------
      case "REGISTRO_TIPO_CONSULTA":
        if (texto === "0")
          return await WhatsappController.regresarAMenu(
            baileysService,
            from,
            estado,
          );

        if (texto === "1") {
          estado.tipo_consulta = "Consulta General";
          estado.duracion_minutos = 30;
        } else if (texto === "2") {
          estado.tipo_consulta = "Cirugía de Cordales";
          estado.duracion_minutos = 60;
        } else {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Opción inválida. Responde *1️⃣* para Consulta General, *2️⃣* para Cirugía o *0️⃣* para Volver:",
          );
        }

        await baileysService.enviarTexto(
          from,
          "📄 Por favor ingresa el *número de documento* del paciente:\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "VALIDAR_DOCUMENTO";
        break;

      case "VALIDAR_DOCUMENTO":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "📌 Selecciona el servicio:\n\n1️⃣ *Consulta General*\n2️⃣ *Cirugía de Cordales*\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_TIPO_CONSULTA";
          return;
        }

        const paciente = await PacienteModel.buscarPorDocumento(texto);

        if (paciente) {
          estado.paciente_id = paciente.id;
          estado.nombre = paciente.nombre;
          await WhatsappController.iniciarSolicitudFecha(
            baileysService,
            from,
            estado,
            paciente.nombre,
          );
        } else {
          estado.documento = texto;
          await baileysService.enviarTexto(
            from,
            "📋 Paciente no encontrado. Para registrarte, selecciona el *Tipo de Documento* del paciente:\n\n" +
              "1️⃣ CC\n" +
              "2️⃣ TI\n" +
              "3️⃣ CE\n" +
              "4️⃣ PAS\n\n" +
              "0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_TIPO_DOC";
        }
        break;

      case "REGISTRO_TIPO_DOC":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "📄 Ingresa el *número de documento* del paciente:\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "VALIDAR_DOCUMENTO";
          return;
        }

        const tipos = { 1: "CC", 2: "TI", 3: "CE", 4: "PAS" };
        if (!tipos[texto]) {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Responde *1️⃣, 2️⃣, 3️⃣ o 4️⃣* o *0️⃣ Volver*:",
          );
        }
        estado.tipo_documento = tipos[texto];

        await baileysService.enviarTexto(
          from,
          "👤 Escribe el *Nombre* del paciente:\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "REGISTRO_NOMBRE";
        break;

      case "REGISTRO_NOMBRE":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "📋 Selecciona Tipo de Documento:\n\n1️⃣ CC\n2️⃣ TI\n3️⃣ CE\n4️⃣ PAS\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_TIPO_DOC";
          return;
        }
        estado.nombre = texto;
        await baileysService.enviarTexto(
          from,
          "✏️ Escribe el *Apellido* del paciente:\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "REGISTRO_APELLIDO";
        break;

      case "REGISTRO_APELLIDO":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "👤 Escribe el *Nombre* del paciente:\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_NOMBRE";
          return;
        }
        estado.apellido = texto;
        await baileysService.enviarTexto(
          from,
          "👤 Selecciona el *Género* del paciente:\n\n1️⃣ Masculino\n2️⃣ Femenino\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "REGISTRO_GENERO";
        break;

      case "REGISTRO_GENERO":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "✏️ Escribe el *Apellido* del paciente:\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_APELLIDO";
          return;
        }
        const generos = { 1: "masculino", 2: "femenino" };
        if (!generos[texto]) {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Responde *1️⃣ Masculino* o *2️⃣ Femenino*:",
          );
        }
        estado.genero = generos[texto];
        await baileysService.enviarTexto(
          from,
          "🎂 Fecha de Nacimiento en formato *AAAA-MM-DD* (Ejemplo: 1995-05-20):\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "REGISTRO_FECHA_NAC";
        break;

      case "REGISTRO_FECHA_NAC":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "👤 Selecciona el *Género*:\n\n1️⃣ Masculino\n2️⃣ Femenino\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_GENERO";
          return;
        }
        const regexFecha = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/;
        if (!regexFecha.test(texto)) {
          return await baileysService.enviarTexto(
            from,
            "❌ Fecha inválida. Usa el formato *AAAA-MM-DD* (Ejemplo: 1995-05-20):",
          );
        }
        estado.fecha_nacimiento = texto;
        await baileysService.enviarTexto(
          from,
          "📞 Escribe un celular de contacto (10 dígitos):\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "REGISTRO_TELEFONO";
        break;

      case "REGISTRO_TELEFONO":
        if (texto === "0") {
          await baileysService.enviarTexto(
            from,
            "🎂 Fecha de Nacimiento (AAAA-MM-DD):\n\n0️⃣ *Volver atrás*",
          );
          estado.paso = "REGISTRO_FECHA_NAC";
          return;
        }

        const telefonoLimpio = esTelefonoValido(texto);
        if (!telefonoLimpio) {
          return await baileysService.enviarTexto(
            from,
            "❌ Número inválido. Debe iniciar por 3 y tener 10 dígitos. Inténtalo de nuevo:",
          );
        }

        estado.telefono = telefonoLimpio;

        await baileysService.enviarTexto(
          from,
          `🔍 *CONFIRMACIÓN DE DATOS DEL PACIENTE*\n\n` +
            `• *Tipo Doc:* ${estado.tipo_documento}\n` +
            `• *Documento:* ${estado.documento}\n` +
            `• *Nombre:* ${estado.nombre} ${estado.apellido}\n` +
            `• *Género:* ${estado.genero}\n` +
            `• *Nacimiento:* ${estado.fecha_nacimiento}\n` +
            `• *Teléfono:* ${estado.telefono}\n\n` +
            `¿Es correcta la información?\n\n` +
            `1️⃣ *Sí, guardar y continuar*\n` +
            `2️⃣ *Corregir datos*\n` +
            `0️⃣ *Volver atrás*`,
        );
        estado.paso = "CONFIRMAR_REGISTRO";
        break;

      case "CONFIRMAR_REGISTRO":
        if (texto === "0" || texto === "2") {
          await baileysService.enviarTexto(
            from,
            "👤 Escribe el *Nombre* del paciente:",
          );
          estado.paso = "REGISTRO_NOMBRE";
          return;
        }

        if (texto === "1") {
          const nuevoId = await PacienteModel.crear({
            nombre: estado.nombre,
            apellido: estado.apellido,
            tipo_documento: estado.tipo_documento,
            documento: estado.documento,
            genero: estado.genero,
            fecha_nacimiento: estado.fecha_nacimiento,
            telefono: estado.telefono,
          });

          estado.paciente_id = nuevoId;
          await baileysService.enviarTexto(
            from,
            "✅ *¡Paciente registrado con éxito!*",
          );
          await WhatsappController.iniciarSolicitudFecha(
            baileysService,
            from,
            estado,
            estado.nombre,
          );
        } else {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Responde *1️⃣* para guardar, *2️⃣* para corregir o *0️⃣* para volver:",
          );
        }
        break;

      // -------------------------------------------------------------
      // SELECCIÓN DE MES
      // -------------------------------------------------------------
      case "SELECCIONAR_MES_Opcion":
        if (texto === "0")
          return await WhatsappController.regresarAMenu(
            baileysService,
            from,
            estado,
          );

        const infoSel = obtenerInfoMeses();
        if (texto === "1") {
          estado.mesSeleccionadoIdx = infoSel.mesActualIdx;
          estado.anoSeleccionado = infoSel.anoActual;
          estado.nombreMesSeleccionado = infoSel.nombreMesActual;
          estado.maxDiasMes = infoSel.ultimoDiaMesActual;
        } else if (texto === "2") {
          estado.mesSeleccionadoIdx = infoSel.mesSigIdx;
          estado.anoSeleccionado = infoSel.anoSigMes;
          estado.nombreMesSeleccionado = infoSel.nombreMesSig;
          estado.maxDiasMes = infoSel.ultimoDiaMesSig;
        } else {
          return await baileysService.enviarTexto(
            from,
            "⚠️ Responde *1️⃣* o *2️⃣*:",
          );
        }

        await baileysService.enviarTexto(
          from,
          `📅 Ingresa el *número del día* deseado para *${estado.nombreMesSeleccionado}*:\n\n0️⃣ *Volver atrás*`,
        );
        estado.paso = "SOLICITAR_DIA";
        break;

      // -------------------------------------------------------------
      // PROCESAMIENTO DEL DÍA
      // -------------------------------------------------------------
      case "SOLICITAR_DIA":
        if (texto === "0")
          return await WhatsappController.regresarAMenu(
            baileysService,
            from,
            estado,
          );

        const diaNum = parseInt(texto, 10);
        const infoM = obtenerInfoMeses();

        if (isNaN(diaNum) || diaNum < 1 || diaNum > 31) {
          return await baileysService.enviarTexto(
            from,
            "❌ Ingresa un número de día válido entre 1 y 31:",
          );
        }

        let mesFinalIdx = estado.mesSeleccionadoIdx;
        let anoFinal = estado.anoSeleccionado;
        let maxDias = estado.maxDiasMes;

        if (mesFinalIdx === undefined) {
          if (diaNum >= infoM.diaHoy) {
            mesFinalIdx = infoM.mesActualIdx;
            anoFinal = infoM.anoActual;
            maxDias = infoM.ultimoDiaMesActual;
          } else {
            mesFinalIdx = infoM.mesSigIdx;
            anoFinal = infoM.anoSigMes;
            maxDias = infoM.ultimoDiaMesSig;
          }
        }

        if (diaNum > maxDias) {
          return await baileysService.enviarTexto(
            from,
            `❌ El mes de *${NOMBRES_MESES[mesFinalIdx]}* solo tiene *${maxDias}* días. Ingresa un día válido:`,
          );
        }

        const mmStr = String(mesFinalIdx + 1).padStart(2, "0");
        const ddStr = String(diaNum).padStart(2, "0");
        const fechaCalculada = `${anoFinal}-${mmStr}-${ddStr}`;

        const yaTieneCitaEseDia = await CitaModel.pacienteTieneCitaEnFecha(
          estado.paciente_id,
          fechaCalculada,
        );
        if (yaTieneCitaEseDia) {
          return await baileysService.enviarTexto(
            from,
            `⚠️ *El paciente ya tiene una cita el ${ddStr} de ${NOMBRES_MESES[mesFinalIdx]}.*\n\nSolo se permite agendar una cita por día. Por favor ingresa un *día diferente*:`,
          );
        }

        const esDiaExclusivo =
          await CitaModel.esFechaExclusivaOrtodoncia(fechaCalculada);
        if (esDiaExclusivo) {
          return await baileysService.enviarTexto(
            from,
            `🗓️ *El día ${ddStr} de ${NOMBRES_MESES[mesFinalIdx]} es de jornada exclusiva de Ortodoncia.*\n\n` +
              `Para este día la atención se agenda de manera presencial en el consultorio, por lo que no hay citas disponibles a través del bot.\n\n` +
              `👉 *Por favor, ingresa un día diferente para agendar tu cita:*`,
          );
        }

        estado.fechaTemp = fechaCalculada;
        estado.fechaFormateadaTextoTemp = `${ddStr} de ${NOMBRES_MESES[mesFinalIdx]} de ${anoFinal}`;

        await baileysService.enviarTexto(
          from,
          `📅 *Confirmación de Fecha*\n\n` +
            `La cita quedará agendada para el día:\n` +
            `👉 *${estado.fechaFormateadaTextoTemp}*\n\n` +
            `¿Deseas continuar con esta fecha?\n\n` +
            `1️⃣ *Sí, seleccionar hora*\n` +
            `2️⃣ *Elegir otro día*\n` +
            `0️⃣ *Volver atrás*`,
        );
        estado.paso = "CONFIRMAR_FECHA_SELECCIONADA";
        break;

      // -------------------------------------------------------------
      // CONFIRMACIÓN OBLIGATORIA DE FECHA
      // -------------------------------------------------------------
      case "CONFIRMAR_FECHA_SELECCIONADA":
        if (texto === "0" || texto === "2") {
          await WhatsappController.iniciarSolicitudFecha(
            baileysService,
            from,
            estado,
            estado.nombre || "paciente",
          );
          return;
        }

        if (texto === "1") {
          estado.fecha = estado.fechaTemp;
          estado.fechaFormateadaTexto = estado.fechaFormateadaTextoTemp;
          const tiempoTexto =
            estado.duracion_minutos === 60 ? "1 hora" : "30 minutos";

          await baileysService.enviarTexto(
            from,
            `⏰ Ingresa la hora para el *${estado.fechaFormateadaTexto}*.\n\n` +
              `📌 *Jornadas:* 8:00 AM - 12:00 PM | 2:00 PM - 6:00 PM\n` +
              `_(Servicio: ${estado.tipo_consulta} - ${tiempoTexto})_\n\n` +
              `_(Ejemplos de hora: 9:00, 10:30 am, 2:00, 4:30 pm)_\n\n0️⃣ *Volver atrás*`,
          );
          estado.paso = "SOLICITAR_HORA";
        } else {
          return await baileysService.enviarTexto(
            from,
            `⚠️ Responde *1️⃣* para confirmar la fecha o *2️⃣* para cambiar el día:`,
          );
        }
        break;

      case "SOLICITAR_HORA":
        if (texto === "0") {
          await WhatsappController.iniciarSolicitudFecha(
            baileysService,
            from,
            estado,
            estado.nombre || "paciente",
          );
          return;
        }

        const horaInicio = normalizarHora(texto, estado.duracion_minutos);

        if (!horaInicio) {
          const tiempoTexto =
            estado.duracion_minutos === 60 ? "1 hora" : "30 minutos";
          return await baileysService.enviarTexto(
            from,
            `❌ *Hora no válida o fuera de rango.*\nSe requiere bloque de *${tiempoTexto}* (8:00-12:00 / 14:00-18:00).\n\nIngresa otra hora:`,
          );
        }

        const horaFinal = calcularHoraFinal(
          horaInicio,
          estado.duracion_minutos,
        );

        const libre = await CitaModel.verificarDisponibilidad(
          estado.fecha,
          horaInicio,
          horaFinal,
        );

        if (!libre) {
          return await baileysService.enviarTexto(
            from,
            `⚠️ El horario (${horaInicio.substring(0, 5)} - ${horaFinal.substring(0, 5)}) está ocupado para el *${estado.fechaFormateadaTexto}*.\n\nIngresa otra hora:`,
          );
        }

        estado.hora = horaInicio;
        estado.hora_final = horaFinal;
        estado.horaMostrar = texto;
        await baileysService.enviarTexto(
          from,
          "📝 Describe brevemente el *motivo de la consulta*:\n\n0️⃣ *Volver atrás*",
        );
        estado.paso = "SOLICITAR_MOTIVO";
        break;

      case "SOLICITAR_MOTIVO":
        if (texto === "0") {
          const tiempoTexto =
            estado.duracion_minutos === 60 ? "1 hora" : "30 minutos";
          await baileysService.enviarTexto(
            from,
            `⏰ Ingresa la hora para el *${estado.fechaFormateadaTexto}*.\n\n` +
              `📌 *Jornadas:* 8:00 AM - 12:00 PM | 2:00 PM - 6:00 PM\n` +
              `_(Servicio: ${estado.tipo_consulta} - ${tiempoTexto})_\n\n0️⃣ *Volver atrás*`,
          );
          estado.paso = "SOLICITAR_HORA";
          return;
        }

        estado.motivo = texto;
        const citaId = await CitaModel.crear({
          paciente_id: estado.paciente_id,
          fecha: estado.fecha,
          hora: estado.hora,
          hora_final: estado.hora_final,
          motivo: `[${estado.tipo_consulta}] ${estado.motivo}`,
        });

        await baileysService.enviarTexto(
          from,
          `✅ *¡Cita agendada con éxito!*\n\n` +
            `• *N° Reserva:* #${citaId}\n` +
            `• *Servicio:* ${estado.tipo_consulta}\n` +
            `• *Fecha:* ${estado.fechaFormateadaTexto}\n` +
            `• *Horario:* ${estado.hora.substring(0, 5)} - ${estado.hora_final.substring(0, 5)}\n` +
            `• *Motivo:* ${estado.motivo}\n\n` +
            `⚠️ *Recuerda:* Llegar con puntualidad a tu cita.\n\n` +
            `¡Te esperamos! 🦷`,
        );

        delete sesiones[from];
        return;
    }
  }

  // ------------------------------------------------------------------
  // MÉTODOS AUXILIARES Y REUTILIZABLES
  // ------------------------------------------------------------------
  static async derivarAAsesor(baileysService, from, estado) {
    estado.paso = "ASESOR";
    resetearTimerInactividad(from, 60);
    return await baileysService.enviarTexto(
      from,
      "👩‍💻 *Un asesor se comunicará contigo en breve.* El bot se ha pausado para brindarte atención personalizada. ¡Un momento por favor!",
    );
  }

  static async regresarAMenu(baileysService, from, estado) {
    await baileysService.enviarTexto(
      from,
      "✨ *Menú Principal*\n\n1️⃣ *Agendar cita*\n2️⃣ *Cancelar cita*\n9️⃣ *Hablar con asesor*",
    );
    estado.paso = "MENU_PRINCIPAL";
  }

  static async iniciarSolicitudFecha(
    baileysService,
    from,
    estado,
    nombrePaciente,
  ) {
    const info = obtenerInfoMeses();

    let penultimoMesLleno = false;
    if (info.esPenultimoDia) {
      const hoyStr = `${info.anoActual}-${String(info.mesActualIdx + 1).padStart(2, "0")}-${String(info.diaHoy).padStart(2, "0")}`;
      const citasHoy = await CitaModel.esFechaExclusivaOrtodoncia(hoyStr);
      if (citasHoy) penultimoMesLleno = true;
    }

    if (info.esUltimoDia || penultimoMesLleno) {
      await baileysService.enviarTexto(
        from,
        `👋 Hola *${nombrePaciente}*.\n\n¿Para qué mes deseas la cita?\n\n` +
          `1️⃣ *${info.nombreMesActual}*\n` +
          `2️⃣ *${info.nombreMesSig}*\n\n` +
          `0️⃣ *Volver atrás*`,
      );
      estado.paso = "SELECCIONAR_MES_Opcion";
    } else {
      await baileysService.enviarTexto(
        from,
        `👋 Hola *${nombrePaciente}*.\n\n` +
          `📅 *Hoy es ${info.diaHoy} de ${info.nombreMesActual}.*\n\n` +
          `Por favor, ingresa el *número del día* en que deseas tu cita.\n\n` +
          `💡 *Nota:* Si ingresas un número menor a hoy (${info.diaHoy}), la cita se agendará automáticamente para el mes de *${info.nombreMesSig}*.\n\n` +
          `0️⃣ *Volver atrás*`,
      );
      estado.paso = "SOLICITAR_DIA";
    }
  }
}

module.exports = WhatsappController;
